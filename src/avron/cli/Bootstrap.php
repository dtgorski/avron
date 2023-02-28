<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

use Avron\AvronException;
use Avron\Config;
use Avron\Logger;
use Avron\StandardWriter;

/**
 * Bootstrap contains exit() invocations and can terminate the process.
 *
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Bootstrap
{
    /**
     * @param Manifest $manifest
     * @param resource $stdin
     * @param resource $stdout
     * @param resource $stderr
     * @param string[] $argv
     */
    public function __construct(
        private readonly Manifest $manifest,
        private readonly mixed $stdin,
        private readonly mixed $stdout,
        private readonly mixed $stderr,
        private readonly array $argv,
    ) {
        $_ = $this->stdin;
    }

    public function run(): void
    {
        $config = Config::fromDefault();

        $logger = new Logger(
            new StandardWriter($this->stdout),
            new StandardWriter($this->stderr)
        );

        $options = Options::fromArray([
            Option::fromMap([
                Option::OPT_SHORT /**/ => "h",
                Option::OPT_LONG /* */ => "help",
                Option::OPT_DESC /* */ => "Display this usage help, also usable on commands.",
            ])





        ,            Option::fromMap([
                Option::OPT_SHORT /**/ => "d",
                Option::OPT_LONG /* */ => "dry-run",
                Option::OPT_DESC /* */ =>
                    "Do not perform writes. Reasonable for diagnosis with --verbose."
            ]),

            Option::fromMap([
                Option::OPT_SHORT /**/ => "e",
                Option::OPT_LONG /* */ => "exclude",
                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
                Option::OPT_ARGN /* */ => "regex",
                Option::OPT_TEST /* */ => fn(string $v) => $v[0] != "-",
                Option::OPT_DESC /* */ =>
                    "Skip files matching the path pattern. The pattern can be a PCRE regular expression. " .
                    "This option can be repeated and aggregates to an OR filter."
            ]),

            Option::fromMap([
                Option::OPT_SHORT /**/ => "f",
                Option::OPT_LONG /* */ => "force",
                Option::OPT_DESC /* */ =>
                    "This utility does not overwrite existing files unless you activate the --force option. " .
                    "If --dry-run is active, this option has no effect."
            ]),

            Option::fromMap([
                Option::OPT_SHORT /**/ => "o",
                Option::OPT_LONG /* */ => "output",
                Option::OPT_MODE /* */ => Option::MODE_ARG_SINGLE,
                Option::OPT_ARGN /* */ => "dir",
                Option::OPT_TEST /* */ => fn(string $v) => $v[0] != "-",
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

        $commands = Commands::fromArray([
            CommandHandlerCompile::create($config, $logger),
            CommandHandlerVerify::create($config, $logger),
        ]);

        try {
            $getOpt = new GetOpt($this->argv, $options, $commands);
            $arguments = $getOpt->createArguments();

            $usage = new Usage($this->argv[0], $this->manifest);
            $usage->renderGlobalHelp($options, $commands);
//            $command->configure($selectedOptions);
//            $command->execute($commandOperands);

        } catch (\Avron\CLI\Exception $e) {
            foreach (explode("\n", trim($e->getMessage())) as $line) {
                $logger->error($line);
            }
            exit(1);

        } catch (\Avron\AvronException $e) {
            foreach (explode("\n", trim($e->getError())) as $line) {
                $logger->error($line);
            }
            exit(1);

        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            foreach (explode("\n", $e->getTraceAsString()) as $line) {
                $logger->error($line);
            }
            exit(1);
        }
    }
}
