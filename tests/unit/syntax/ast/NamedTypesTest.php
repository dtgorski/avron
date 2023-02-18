<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\NamedTypes
 */
class NamedTypesTest extends TestCase
{
    public function testNamedType(): void
    {
        $this->assertSame("enum", NamedTypes::enum->name);
        $this->assertSame("enum", NamedTypes::enum->value);

        $this->assertSame("error", NamedTypes::error->name);
        $this->assertSame("error", NamedTypes::error->value);

        $this->assertSame("fixed", NamedTypes::fixed->name);
        $this->assertSame("fixed", NamedTypes::fixed->value);

        $this->assertSame("record", NamedTypes::record->name);
        $this->assertSame("record", NamedTypes::record->value);

        $this->assertEquals(NamedTypes::names(), NamedTypes::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(NamedTypes::hasType("enum"));
        $this->assertTrue(NamedTypes::hasType("error"));
        $this->assertTrue(NamedTypes::hasType("fixed"));
        $this->assertTrue(NamedTypes::hasType("record"));
    }
}
