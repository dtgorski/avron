<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommandHandlerVersion implements Handler
{
    private const NAME = "version";
    private const ARGS = "";
    private const DESC = "Print program version and exit.";

    /** @return Options */
    private static function options(): Options
    {
        return Options::fromArray([]);
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
