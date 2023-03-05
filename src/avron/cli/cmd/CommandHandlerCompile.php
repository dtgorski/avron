<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Factory;
use Avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommandHandlerCompile implements Handler
{
    private const NAME = "compile";
    private const ARGS = "[OPTION...] FILE...";
    private const DESC = "Compile Avro IDL to target representation.";

    /** @return Options */
    private static function options(): Options
    {
        return Options::fromArray([
            Option::fromMap([
                Option::OPT_SHORT /**/ => "h",
                Option::OPT_LONG /* */ => "help",
                Option::OPT_DESC /* */ =>
                    "Display this usage help."
            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "d",
                Option::OPT_LONG /* */ => "dry-run",
                Option::OPT_DESC /* */ =>
                    "Does not perform writes. Reasonable for diagnosis with --verbose."
            ]),
//            Option::fromMap([
//                Option::OPT_SHORT /**/ => "e",
//                Option::OPT_LONG /* */ => "exclude",
//                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
//                Option::OPT_ARGN /* */ => "regex",
//                Option::OPT_DESC /* */ =>
//                    "Skip files matching the path pattern. The pattern can be a PCRE regular expression. " .
//                    "This option can be repeated and aggregates to an OR filter."
//            ]),
//            Option::fromMap([
//                Option::OPT_SHORT /**/ => "f",
//                Option::OPT_LONG /* */ => "force",
//                Option::OPT_DESC /* */ =>
//                    "This utility does not overwrite existing files unless you activate the --force option. " .
//                    "If --dry-run is active, this option has no effect."
//            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "o",
                Option::OPT_LONG /* */ => "output",
                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
                Option::OPT_ARGN /* */ => "dir",
                Option::OPT_DESC /* */ =>
                    "Denotes the output directory for the transpilation target. Existing files " .
                    "are not overwritten unless you specify the --force option. In general, it is " .
                    "not advisable to overwrite results, to avoid clutter with obsolete files. " .
                    "If you do not provide this option, the application will enter the dry-run " .
                    "mode and files will not be created nor modified."
            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "v",
                Option::OPT_LONG /* */ => "verbose",
                Option::OPT_DESC /* */ =>
                    "Increases output verbosity level for diagnostic purposes."
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
        $config = $this->config;
        $config->set(Config::PERFORM_DRY_RUN, $options->getByName("dry-run") || !$options->getByName("output"));
        $config->set(Config::OUTPUT_DIRECTORY, $options->getByName("output") ?? "");
        $config->set(Config::VERBOSITY_LEVEL, $options->getByName("verbose") ?? 0);
    }

//    /** @throws Exception */
    public function execute(Operands $operands): void
    {
        $factory = new Factory($this->config, $this->logger);
        $sourceMap = $factory->createProtocolLoader()->load(...$operands->asArray());
//
////        foreach ($sourceMap as $visitable) {
////            $visitable->accept($factory->createAvdlPrinter());
////        }
    }
}
