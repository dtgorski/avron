<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Command
{
    /**
     * @param string $name
     * @param string $args
     * @param string $desc
     * @param Options $options
     * @param Handler $handler
     * @return Command
     */
    public static function fromParams(
        string $name,
        string $args,
        string $desc,
        Options $options,
        Handler $handler
    ): Command {
        return new Command($name, $args, $desc, $options, $handler);
    }

    private function __construct(
        private readonly string $name,
        private readonly string $args,
        private readonly string $desc,
        private readonly Options $options,
        private readonly Handler $handler
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsageArgs(): string
    {
        return $this->args;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    public function getHandler(): Handler
    {
        return $this->handler;
    }
}
