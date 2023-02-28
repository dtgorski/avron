<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\AvronException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Core\RealPath
 */
class RealPathTest extends TestCase
{
    public function testRealPath(): void
    {
        $path = RealPath::fromString(__FILE__);
        $this->assertEquals(basename(__FILE__), $path->getName());
        $this->assertEquals(dirname(__FILE__), $path->getDir());
        $this->assertEquals(__FILE__, $path->getPath());
        $this->assertEquals(__FILE__, $path->__toString());
    }

    public function testThrowsExceptionWhenPathInvalid(): void
    {
        $this->expectException(AvronException::class);
        $path = RealPath::fromString("-");
    }
}
