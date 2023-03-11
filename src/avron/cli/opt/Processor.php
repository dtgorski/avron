<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use ArrayIterator;
use Avron\Api\TreeNode;
use Exception;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Processor
{
    public function __construct(
        private readonly TreeNode $node,
        private readonly Arguments $arguments
    ) {
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function process(): void
    {
        /** @var ArrayIterator<int,Argument> $it */
        $it = $this->arguments->getIterator();

        echo "process";
    }
}
