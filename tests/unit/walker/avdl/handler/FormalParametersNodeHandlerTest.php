<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\FormalParametersNode;
use Avron\AST\MessageDeclarationNode;

/**
 * @covers \Avron\AVDL\FormalParametersNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\FormalParametersNode
 * @uses   \Avron\AST\MessageDeclarationNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
