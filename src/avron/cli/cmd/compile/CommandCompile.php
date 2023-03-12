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
class CommandCompile extends Command
{
    public static function create(Config $config, Logger $logger): Command
    {
        return new self($config, $logger);
    }

    private function __construct(
        private readonly Config $config,
        private readonly Logger $logger
    ) {
        parent::__construct(self::NAME, self::PARA, self::DESC);
    }

    private const NAME = "compile";
    private const PARA = "TARGET [OPTION...] FILE...";
    private const DESC = "Compile Avro IDL to source code.";

    public function options(): Options
    {
        return Options::fromArray([
//            Option::fromMap([
//                Option::OPT_SHORT /**/ => "h",
//                Option::OPT_LONG /* */ => "help",
//                Option::OPT_DESC /* */ =>
//                    "Display this usage help.",
//            ]),
//            Option::fromMap([
//                Option::OPT_SHORT /**/ => "d",
//                Option::OPT_LONG /* */ => "dry-run",
//                Option::OPT_DESC /* */ =>
//                    "Does not perform writes. Reasonable for diagnosis with --verbose."
//            ]),
//            Option::fromMap([
//                Option::OPT_SHORT /**/ => "v",
//                Option::OPT_LONG /* */ => "verbose",
//                Option::OPT_DESC /* */ =>
//                    "Increases output verbosity level for diagnostic purposes."
//            ]),
            Option::fromMap([
                Option::OPT_SHORT /**/ => "o",
                Option::OPT_LONG /* */ => "output",
                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
                Option::OPT_ARGN /* */ => "dir",
                Option::OPT_DESC /* */ =>
                    "Designates the directory for the compilation target. Directory must exist. " .
                    "Existing files will not be overwritten. Default is /dev/null."
            ]),
        ]);
    }

    public function configure(Options $options): void
    {
        $config = $this->config;
        $config->set(Config::PERFORM_DRY_RUN, $options->getByName("dry-run") || !$options->getByName("output"));
        $config->set(Config::OUTPUT_DIRECTORY, $options->getByName("output") ?? "");
        $config->set(Config::VERBOSITY_LEVEL, $options->getByName("verbose") ?? 0);
    }

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
