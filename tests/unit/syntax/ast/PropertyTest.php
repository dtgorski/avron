<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

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
        $this->assertEquals('{"foo":"bar"}', json_encode($prop));
    }

    public function testGetNameGetValueBool(): void
    {
        $prop = new Property("foo", true);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals(true, $prop->getValue());
        $this->assertEquals('{"foo":true}', json_encode($prop));
    }

    public function testGetNameGetValueNumber(): void
    {
        $prop = new Property("foo", 4.2);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals(4.2, $prop->getValue());
        $this->assertEquals('{"foo":4.2}', json_encode($prop));
    }

    public function testGetNameGetValueArray(): void
    {
        $prop = new Property("foo", [new Property("x", "y")]);
        $this->assertEquals("foo", $prop->getName());
        $this->assertEquals([new Property("x", "y")], $prop->getValue());
        $this->assertEquals('{"foo":[{"x":"y"}]}', json_encode($prop));
    }
}
