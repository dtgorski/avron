<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\JsonValueNode;

/**
 * @covers \Avron\Idl\JsonValueNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\JsonValueNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class JsonValueNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new JsonValueNodeHandler($ctx);
        $node = new JsonValueNode(null);

        $this->assertTrue($handler->canHandle($node));
    }

    /** @dataProvider provideJsonValues */
    public function testHandleVisit(mixed $value, string $expect): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonValueNodeHandler($ctx);
        $handler->handleVisit(new JsonValueNode($value));

        $this->assertEquals($expect, $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAstNode();
        $node->addNode(new JsonValueNode(42));
        $node->addNode(new JsonValueNode(42));

        $handler = new JsonValueNodeHandler($ctx);
        $handler->handleVisit($node->nodeAt(1));

        $this->assertEquals(", 42", $writer->getBuffer());
    }

    public function provideJsonValues(): array
    {
        // @formatter:off
        return [
            ["value" => 42,    "expect" => "42" ],
            ["value" => "42",  "expect" => '"42"' ],
            ["value" => null,  "expect" => "null" ],
            ["value" => true,  "expect" => "true" ],
            ["value" => false, "expect" => "false" ],
        ];
    }
}
