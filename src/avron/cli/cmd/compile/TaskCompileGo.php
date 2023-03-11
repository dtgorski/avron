<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class TaskCompileGo extends Command
{
    private const NAME = "go";
    private const ARGS = "[OPTION...] FILE...";
    private const DESC = "Compile Avro IDL to Go source code.";

    public function supported(): Options
    {
        return Options::fromArray([
            Option::fromMap([
                Option::OPT_SHORT /**/ => "h",
                Option::OPT_LONG /* */ => "help",
                Option::OPT_DESC /* */ =>
                    "Display this usage help.",
            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "d",
                Option::OPT_LONG /* */ => "dry-run",
                Option::OPT_DESC /* */ =>
                    "Does not perform writes. Reasonable for diagnosis with --verbose."
            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "v",
                Option::OPT_LONG /* */ => "verbose",
                Option::OPT_DESC /* */ =>
                    "Increases output verbosity level for diagnostic purposes."
            ]),
        ]);
    }

    public static function create(Config $config, Logger $logger): TaskCompileGo
    {
        return new TaskCompileGo($config, $logger);
    }


    private function __construct(
        private readonly Config $config,
        private readonly Logger $logger
    ) {
        parent::__construct();
    }

    public function configure(Options $options): void
    {
    }

    public function execute(Operands $operands): void
    {
    }
}
