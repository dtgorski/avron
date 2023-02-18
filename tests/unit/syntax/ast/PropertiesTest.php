<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Property
 */
class PropertiesTest extends TestCase
{
    public function testAddGetProperties()
    {
        $props = new Properties();
        $this->assertSame(null, $props->getByName("x"));

        $props->add(new Property("x", 1));
        $props->add(new Property("Y", 2));

        $this->assertEquals(1, $props->getByName("x")->getValue());
        $this->assertEquals(2, $props->getByName("Y")->getValue());

        $props->add(new Property("a", "b"));
        $this->assertEquals('{"0":{"x":1},"1":{"Y":2},"2":{"a":"b"}}', json_encode($props));

        $this->assertSame(3, $props->size());

        $i = 0;
        foreach ($props as $prop) {
            if ($i == 0) {
                $this->assertEquals("x", $prop->getName());
            }
            if ($i == 1) {
                $this->assertEquals("Y", $prop->getName());
            }
            if ($i == 2) {
                $this->assertEquals("a", $prop->getName());
            }
            $i++;
        }
    }
}