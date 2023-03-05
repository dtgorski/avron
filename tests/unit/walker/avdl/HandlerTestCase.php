<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\DeclarationNode;
use Avron\Ast\Node;
use Avron\BufferedWriter;
use PHPUnit\Framework\TestCase;

class HandlerTestCase extends TestCase
{
    protected function createContextAndWriter(): array
    {
        $writer = new BufferedWriter();
        $ctx = $this->createMock(HandlerContext::class);
        $ctx->method("getWriter")->willReturn($writer);

        return [$ctx, $writer];
    }

    protected function createAnonymousNode(): Node
    {
        return new class extends Node {
        };
    }

    protected function createDeclarationNode(): DeclarationNode
    {
        return new class extends DeclarationNode {
        };
    }
}
