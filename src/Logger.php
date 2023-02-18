<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\Writer;

class Logger
{
    public function __construct(
        private readonly Writer $stdout,
        private readonly Writer $stderr,
    ) {
    }

    public function info(string|float|int|null ...$msgs): void {
        $this->stdout->write("[info] ");
        foreach ($msgs as $msg) $this->stdout->write($msg);
        $this->stdout->write("\n");
    }

    public function warn(string|float|int|null ...$msgs): void {
        $this->stderr->write("[warn] ");
        foreach ($msgs as $msg) $this->stderr->write($msg);
        $this->stderr->write("\n");
    }

    public function error(string|float|int|null ...$msgs): void {
        $this->stderr->write("[error] ");
        foreach ($msgs as $msg) $this->stderr->write($msg);
        $this->stderr->write("\n");
    }
}
