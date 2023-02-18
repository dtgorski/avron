<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\PrimitiveTypes
 */
class PrimitiveTypesTest extends TestCase
{
    public function testPrimitiveType(): void
    {
        $this->assertSame("boolean", PrimitiveTypes::boolean->name);
        $this->assertSame("boolean", PrimitiveTypes::boolean->value);

        $this->assertSame("bytes", PrimitiveTypes::bytes->name);
        $this->assertSame("bytes", PrimitiveTypes::bytes->value);

        $this->assertSame("int", PrimitiveTypes::int->name);
        $this->assertSame("int", PrimitiveTypes::int->value);

        $this->assertSame("string", PrimitiveTypes::string->name);
        $this->assertSame("string", PrimitiveTypes::string->value);

        $this->assertSame("float", PrimitiveTypes::float->name);
        $this->assertSame("float", PrimitiveTypes::float->value);

        $this->assertSame("double", PrimitiveTypes::double->name);
        $this->assertSame("double", PrimitiveTypes::double->value);

        $this->assertSame("long", PrimitiveTypes::long->name);
        $this->assertSame("long", PrimitiveTypes::long->value);

        $this->assertSame("null", PrimitiveTypes::null->name);
        $this->assertSame("null", PrimitiveTypes::null->value);

        $this->assertEquals(PrimitiveTypes::names(), PrimitiveTypes::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(PrimitiveTypes::hasType("boolean"));
        $this->assertTrue(PrimitiveTypes::hasType("bytes"));
        $this->assertTrue(PrimitiveTypes::hasType("int"));
        $this->assertTrue(PrimitiveTypes::hasType("string"));
        $this->assertTrue(PrimitiveTypes::hasType("float"));
        $this->assertTrue(PrimitiveTypes::hasType("double"));
        $this->assertTrue(PrimitiveTypes::hasType("long"));
        $this->assertTrue(PrimitiveTypes::hasType("null"));
    }
}
