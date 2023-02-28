<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron;

/**
 * @covers \lengo\avron\StandardWriter
 */
class StandardWriterTest extends AvronTestCase
{
    public function testWrite(): void
    {
        $stream = $this->createStream("");
        $writer = new StandardWriter($stream);

        $out = "foo\n";
        $writer->write($out);

        fseek($stream, 0);
        $this->assertEquals("foo\n", fread($stream, strlen($out)));
    }
}
