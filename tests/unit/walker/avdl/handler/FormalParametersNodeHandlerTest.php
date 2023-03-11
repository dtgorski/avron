<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\FormalParametersNode;
use Avron\Ast\MessageDeclarationNode;

/**
 * @covers \Avron\Idl\FormalParametersNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\FormalParametersNode
 * @uses   \Avron\Ast\MessageDeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class FormalParametersNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new FormalParametersNodeHandler($ctx);
        $node = new FormalParametersNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new FormalParametersNodeHandler($ctx);
        $message = new MessageDeclarationNode("name");
        $message->addNode($node = new FormalParametersNode());
        $handler->handleVisit($node);

        $this->assertEquals(" name(", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new FormalParametersNodeHandler($ctx);
        $message = new MessageDeclarationNode("name");
        $message->addNode($node = new FormalParametersNode());
        $handler->handleLeave($node);

        $this->assertEquals(")", $writer->getBuffer());
    }
}
