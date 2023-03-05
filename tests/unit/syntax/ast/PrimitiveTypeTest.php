<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\PrimitiveType
 */
class PrimitiveTypeTest extends TestCase
{
    public function testPrimitiveType(): void
    {
        $this->assertSame("boolean", PrimitiveType::boolean->name);
        $this->assertSame("boolean", PrimitiveType::boolean->value);

        $this->assertSame("bytes", PrimitiveType::bytes->name);
        $this->assertSame("bytes", PrimitiveType::bytes->value);

        $this->assertSame("int", PrimitiveType::int->name);
        $this->assertSame("int", PrimitiveType::int->value);

        $this->assertSame("string", PrimitiveType::string->name);
        $this->assertSame("string", PrimitiveType::string->value);

        $this->assertSame("float", PrimitiveType::float->name);
        $this->assertSame("float", PrimitiveType::float->value);

        $this->assertSame("double", PrimitiveType::double->name);
        $this->assertSame("double", PrimitiveType::double->value);

        $this->assertSame("long", PrimitiveType::long->name);
        $this->assertSame("long", PrimitiveType::long->value);

        $this->assertSame("null", PrimitiveType::null->name);
        $this->assertSame("null", PrimitiveType::null->value);

        $this->assertEquals(PrimitiveType::names(), PrimitiveType::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(PrimitiveType::hasType("boolean"));
        $this->assertTrue(PrimitiveType::hasType("bytes"));
        $this->assertTrue(PrimitiveType::hasType("int"));
        $this->assertTrue(PrimitiveType::hasType("string"));
        $this->assertTrue(PrimitiveType::hasType("float"));
        $this->assertTrue(PrimitiveType::hasType("double"));
        $this->assertTrue(PrimitiveType::hasType("long"));
        $this->assertTrue(PrimitiveType::hasType("null"));
    }
}
