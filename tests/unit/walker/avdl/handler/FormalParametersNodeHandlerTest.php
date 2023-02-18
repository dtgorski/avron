<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\FormalParametersNode;
use lengo\avron\ast\MessageDeclarationNode;

/**
 * @covers \lengo\avron\avdl\FormalParametersNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\FormalParametersNode
 * @uses   \lengo\avron\ast\MessageDeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
