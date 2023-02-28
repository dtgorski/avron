<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use Avron\API\Writer;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Logger
{
    public function __construct(
        private readonly Writer $stdout,
        private readonly Writer $stderr,
    ) {
    }

    public function info(string|float|int|null ...$msgs): void
    {
        $this->stdout->write("[info] ");
        foreach ($msgs as $msg) {
            $this->stdout->write($msg);
        }
        $this->stdout->write("\n");
    }

    public function warn(string|float|int|null ...$msgs): void
    {
        $this->stderr->write("[warn] ");
        foreach ($msgs as $msg) {
            $this->stderr->write($msg);
        }
        $this->stderr->write("\n");
    }

    public function error(string|float|int|null ...$msgs): void
    {
        $this->stderr->write("[error] ");
        foreach ($msgs as $msg) {
            $this->stderr->write($msg);
        }
        $this->stderr->write("\n");
    }
}
