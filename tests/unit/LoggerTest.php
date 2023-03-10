<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Logger
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\StandardWriter
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
