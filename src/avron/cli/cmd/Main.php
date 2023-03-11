<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\avron\cli\cmd;

use Avron\Cli\Command;
use Avron\Cli\Operands;
use Avron\Cli\Option;
use Avron\Cli\Options;
use Avron\Config;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Main extends Command
{
    private const NAME = "";
    private const ARGS = "[OPTION...] [COMMAND [OPTION...] FILE...]";
    private const DESC = "Apache Avro IDL transpiler.";

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

    public static function create(Config $config, Logger $logger): Main
    {
        return new Main($config, $logger);
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
        // fall through
    }
}
