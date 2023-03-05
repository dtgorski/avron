<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

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

        $mainHandler = OptionsHandlerMain::create($config, $logger);

        $commands = Commands::fromArray([
            CommandHandlerCompile::create($config, $logger),
        ]);

        try {
            $getOpt = new GetOpt($this->argv, $mainHandler->getOptions(), $commands);
            $params = $getOpt->createParameters();

            if ($params->getOptions()) {
                print_r($params);
            }

//            $command->configure($selectedOptions);
//            $command->execute($commandOperands);

        } catch (\Avron\Cli\Exception $e) {
            foreach (explode("\n", trim($e->getMessage())) as $line) {
                $logger->error($line);
            }
            $usage = new Usage($this->argv[0], $this->manifest);
            $usage->renderUsage($mainHandler->getOptions(), $commands);
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
