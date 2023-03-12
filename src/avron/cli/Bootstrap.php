<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Config;
use Avron\Diag\DumpAstVisitor;
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
     * @param resource $stdout
     * @param resource $stderr
     * @param string[] $args
     */
    public function __construct(
        private readonly Manifest $manifest,
        private readonly mixed $stdout,
        private readonly mixed $stderr,
        private readonly array $args,
    ) {
    }

    public function run(): void
    {
        $config = Config::fromDefault();

        $logger = new Logger(
            new StandardWriter($this->stdout),
            new StandardWriter($this->stderr)
        );

        $commandTree = CommandMain::create($config, $logger);

        $commandTree->addNode(
            CommandCompile::create($config, $logger)->addNode(
                TaskCompilePHP8::create($config, $logger),
                TaskCompileGo::create($config, $logger),
            ),
            CommandVerify::create($config, $logger),
        );
//print_r($commandTree);
//        $commandTree->accept(new DumpAstVisitor());

        try {
            $arguments = Classifier::parseArguments($this->args);

//            $p = new Processor($arguments);
//            $p->process($tree);

            $r = new Renderer();
            $u = new Usage($this->manifest, $r);
            $u->render($commandTree);
            echo "\n-------------------------------------------------------\n";
            $r = new Renderer();
            $u = new Usage($this->manifest, $r);
            $u->render($commandTree->childNodes()[0]);
            echo "\n-------------------------------------------------------\n";
            $r = new Renderer();
            $u = new Usage($this->manifest, $r);
            $u->render($commandTree->childNodes()[0]->childNodes()[0]);
//            $params = $getOpt->createParameters();
//
//            if ($params->getOptions()) {
//                print_r($params);
//            }

//            $command->configure($selectedOptions);
//            $command->execute($commandOperands);

#            $tree->accept(new Usage());

        } catch (\Avron\Cli\Exception $e) {
            $this->error($logger, $e->getMessage());
            //  $usage = new Usage($this->manifest);
            //$usage->renderUsage($command, $commands);
            exit(1);

        } catch (\Avron\AvronException $e) {
            $this->error($logger, $e->getError());
            exit(1);

        } catch (\Exception $e) {
            $this->error($logger, $e->getMessage());
            $this->error($logger, $e->getTraceAsString());
            exit(1);
        }
    }

    private function error(Logger $logger, string $msg): void
    {
        foreach (explode("\n", trim($msg)) as $line) {
            $logger->error($line);
        }
    }
}
