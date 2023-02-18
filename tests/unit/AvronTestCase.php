<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use PHPUnit\Framework\TestCase;

class AvronTestCase extends TestCase
{
    /** @return resource */
    protected function openStream(string $filename)
    {
        return fopen($filename, "r");
    }

    /** @return resource */
    protected function createStream(string $source)
    {
        $stream = fopen("php://memory", "rw");
        fwrite($stream, $source);
        fseek($stream, 0);
        return $stream;
    }

    /** @var $stream resource */
    protected function closeStream($stream): void
    {
        fclose($stream);
    }
}
