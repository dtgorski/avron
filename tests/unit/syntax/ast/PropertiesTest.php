<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\Properties
 * @uses   \Avron\AST\Property
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
        $this->assertEquals('{"0":{"foo":1},"1":{"bar":2}}', json_encode($properties));
        $this->assertSame($property1, $properties->getIterator()->current());
    }
}
