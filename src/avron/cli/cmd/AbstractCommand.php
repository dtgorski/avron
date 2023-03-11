<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Core\VisitableNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class AbstractCommand extends VisitableNode
{
    protected function __construct(
        private readonly string $name,
        private readonly string $args,
        private readonly string $desc,
        private readonly Options $options,
    ) {
        parent::__construct();
    }

    abstract public function configure(Options $options): void;

    /** @throws GetOptException */
    abstract public function execute(Operands $operands): void;
}
