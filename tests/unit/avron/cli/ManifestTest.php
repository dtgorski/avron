<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\CLI\Manifest
 */
class ManifestTest extends TestCase
{
    public function testFromParams()
    {
        $mani = Manifest::fromParams("foo", "bar", "baz");

        $this->assertEquals("foo", $mani->getName());
        $this->assertEquals("bar", $mani->getVersion());
        $this->assertEquals("baz", $mani->getDescription());
    }
}
