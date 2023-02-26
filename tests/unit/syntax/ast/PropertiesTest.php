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
    public function testProperties()
    {
        $props = Properties::fromArray([
            new Property("x", 1),
            new Property("Y", 2)
        ]);

        $this->assertSame(null, $props->getByName("z"));
        $this->assertEquals(1, $props->getByName("x")->getValue());
        $this->assertEquals(2, $props->getByName("Y")->getValue());

        $this->assertSame(2, $props->size());

//        $test = function (Property $prop, int $i): void {
//            $expect = ["x", "Y"];
//            $this->assertEquals($expect[$i], $prop->getName());
//        };
//
//        $i = 0;
//        foreach ($props as $prop) {
//            $test($prop, $i++);
//        }
    }
}
