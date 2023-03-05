<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class OptionsHandlerMain implements Handler
{
    /** @return Options */
    private static function options(): Options
    {
        return Options::fromArray([
            Option::fromMap([
                Option::OPT_SHORT /**/ => "h",
                Option::OPT_LONG /* */ => "help",
                Option::OPT_DESC /* */ =>
                    "Display this usage help.",
            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "v",
                Option::OPT_LONG /* */ => "verbose",
                Option::OPT_DESC /* */ =>
                    "Increases output verbosity level for diagnostic purposes."
            ]),
        ]);
    }

    public static function create(Config $config, Logger $logger): OptionsHandlerMain
    {
        return new self($config, $logger, self::options());
    }


    private function __construct(
        private readonly Config $config,
        private readonly Logger $logger,
        private readonly Options $options,
    ) {
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    public function configure(Options $options): void
    {
    }

    public function execute(Operands $operands): void
    {
    }
}
