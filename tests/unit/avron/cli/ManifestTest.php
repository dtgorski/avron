<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Manifest
 */
class ManifestTest extends TestCase
{
    public function testFromParams()
    {
        $man = Manifest::fromParams("foo", "bar", "baz");

        $this->assertEquals("foo", $man->getName());
        $this->assertEquals("bar", $man->getVersion());
        $this->assertEquals("baz", $man->getDescription());
    }
}
