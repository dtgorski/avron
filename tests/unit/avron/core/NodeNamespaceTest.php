<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\AvronException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\core\NodeNamespace
 */
class NodeNamespaceTest extends TestCase
{
    /** @dataProvider provideValidNamespaceNames */
    public function testValidNamespaces(string $namespace): void
    {
        try {
            NodeNamespace::fromString($namespace);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true);
    }

    public function provideValidNamespaceNames(): array
    {
        return [
            [""], ["_"], ["x"], ["x.y"], ["x.y.z"], ["x1.y.z"], ["x_"], ["_x"],
        ];
    }

    /** @dataProvider provideInvalidNamespaceNames */
    public function testInvalidNamespaces(string $namespace): void
    {
        $this->expectException(AvronException::class);
        NodeNamespace::fromString($namespace);
    }

    public function provideInvalidNamespaceNames(): array
    {
        return [
            ["."], [".x"], ["x."], ["1"], ["x.1"], ["x-y"], ["_x."]
        ];
    }
}
