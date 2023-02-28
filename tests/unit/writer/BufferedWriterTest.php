<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\BufferedWriter
 */
class BufferedWriterTest extends TestCase
{
    public function testWrite(): void
    {
        $writer = new BufferedWriter();

        $writer->write("foo\n");
        $writer->write("bar\n");
        $this->assertEquals("foo\nbar\n", $writer->getBuffer());

        $writer->clearBuffer();
        $this->assertEquals("", $writer->getBuffer());
    }
}
