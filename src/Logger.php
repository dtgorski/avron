<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\Writer;

class Logger
{
    public function __construct(
        private readonly Writer $stdoutWriter,
        private readonly Writer $stderrWriter,
    ) {
    }

    public function info(string|float|int|null ...$msgs): void {
        $this->stdoutWriter->write("info: ");
        foreach ($msgs as $msg) $this->stdoutWriter->write($msg);
        $this->stdoutWriter->write("\n");
    }

    public function warn(string|float|int|null ...$msgs): void {
        $this->stderrWriter->write("warn: ");
        foreach ($msgs as $msg) $this->stderrWriter->write($msg);
        $this->stderrWriter->write("\n");
    }

    public function error(string|float|int|null ...$msgs): void {
        $this->stderrWriter->write("error: ");
        foreach ($msgs as $msg) $this->stderrWriter->write($msg);
        $this->stderrWriter->write("\n");
    }
}
