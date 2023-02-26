<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\Property
 */
class PropertyTest extends TestCase
{
    public function testGetNameGetValueString(): void
    {
        $prop = new Property("foo", "bar");
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals("bar", $prop->getValue());
    }

    public function testGetNameGetValueBool(): void
    {
        $prop = new Property("foo", true);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals(true, $prop->getValue());
    }

    public function testGetNameGetValueNumber(): void
    {
        $prop = new Property("foo", 4.2);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals(4.2, $prop->getValue());
    }

    public function testGetNameGetValueArray(): void
    {
        $prop = new Property("foo", [new Property("x", "y")]);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals([new Property("x", "y")], $prop->getValue());
    }
}
