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
        $property1 = new Property("foo", 1);
        $property2 = new Property("bar", 2);

        $properties = Properties::fromArray([$property1, $property2]);

        $this->assertSame($property1, $properties->getByName("foo"));
        $this->assertSame($property2, $properties->getByName("bar"));

        $this->assertSame(null, $properties->getByName(""));
        $this->assertSame(2, $properties->size());

        $this->assertEquals([$property1, $property2], $properties->asArray());
    }
}
