<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommandHandlerVerify implements Handler
{
    private const NAME = "verify";
    private const ARGS = "[OPTIONS...] FILE...";
    private const DESC = "Verify Avro IDL syntax and integrity.";

    /** @return Options */
    private static function options(): Options
    {
        return Options::fromArray([
            Option::fromMap([
                Option::OPT_SHORT /**/ => "e",
                Option::OPT_LONG /* */ => "exclude",
                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
                Option::OPT_ARGN /* */ => "regex",
                Option::OPT_DESC /* */ =>
                    "Skip files matching the path pattern. The pattern can be a PCRE regular expression. " .
                    "This option can be repeated and aggregates to an OR filter."
            ]),
        ]);
    }

    public static function create(Config $config, Logger $logger): Command
    {
        return Command::fromParams(
            self::NAME,
            self::ARGS,
            self::DESC,
            self::options(),
            new self($config, $logger)
        );
    }

    private function __construct(
        private readonly Config $config,
        private readonly Logger $logger
    ) {
    }

    public function configure(Options $options): void
    {
    }

    public function execute(Operands $operands): void
    {
    }
}
