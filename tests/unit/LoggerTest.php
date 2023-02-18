<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\Logger
 * @uses   \lengo\avron\BufferedWriter
 * @uses   \lengo\avron\StderrWriter
 * @uses   \lengo\avron\StdoutWriter
 */
class LoggerTest extends TestCase
{
    public function testLog(): void
    {
        $logger = new Logger(
            $stdout = new BufferedWriter(),
            $stderr = new BufferedWriter()
        );

        $logger->info("foo");
        $logger->warn("bar");
        $logger->error("baz");

        $this->assertEquals("[info] foo\n", $stdout->getBuffer());
        $this->assertEquals("[warn] bar\n[error] baz\n", $stderr->getBuffer());
    }
}
