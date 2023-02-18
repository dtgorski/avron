<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\JsonValueNode;

/**
 * @covers \lengo\avron\avdl\JsonValueNodeHandler
 * @uses   \lengo\avron\ast\JsonValueNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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

        $node = $this->createAnonymousNode();
        $node->addNode(new JsonValueNode(42));
        $node->addNode(new JsonValueNode(42));

        $handler = new JsonValueNodeHandler($ctx);
        $handler->handleVisit($node->getChildNodeAt(1));

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