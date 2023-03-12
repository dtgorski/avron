<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Core\TreeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class Command extends TreeNode
{
    public function __construct(
        private readonly string $name,
        private readonly string $para,
        private readonly string $desc,
    )
    {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): string
    {
        return $this->para;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }

    public function getPath(): string
    {
        /** @var Command|null $parent */
        if ($parent = $this->parentNode()) {
            return sprintf("%s %s", $parent->getPath(), $this->getName());
        }
        return $this->getName();
    }

    /** @return Options All Option definitions for this command. */
    abstract public function options(): Options;

    /** @param Options $options That have been selected with their applied values. */
    abstract public function configure(Options $options): void;

    /**
     * @throws \Avron\Cli\Exception
     * @throws \Avron\AvronException
     */
    abstract public function execute(Operands $operands): void;
}
