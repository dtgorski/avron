<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\NamedType
 */
class NamedTypeTest extends TestCase
{
    public function testNamedType(): void
    {
        $this->assertSame("enum", NamedType::enum->name);
        $this->assertSame("enum", NamedType::enum->value);

        $this->assertSame("error", NamedType::error->name);
        $this->assertSame("error", NamedType::error->value);

        $this->assertSame("fixed", NamedType::fixed->name);
        $this->assertSame("fixed", NamedType::fixed->value);

        $this->assertSame("record", NamedType::record->name);
        $this->assertSame("record", NamedType::record->value);

        $this->assertEquals(NamedType::names(), NamedType::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(NamedType::hasType("enum"));
        $this->assertTrue(NamedType::hasType("error"));
        $this->assertTrue(NamedType::hasType("fixed"));
        $this->assertTrue(NamedType::hasType("record"));
    }
}
