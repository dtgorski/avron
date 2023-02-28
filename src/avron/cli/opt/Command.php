<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Command
{
    /**
     * @param string $name
     * @param string $desc
     * @param Handler $handler
     * @param ?Options $options
     * @return Command
     */
    public static function fromParams(
        string $name,
        string $desc,
        Handler $handler,
        ?Options $options
    ): Command {
        return new Command($name, $desc, $handler, $options);
    }

    private function __construct(
        private readonly string $name,
        private readonly string $desc,
        private readonly Handler $handler,
        private readonly ?Options $options
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }

    public function getHandler(): Handler
    {
        return $this->handler;
    }

    public function getOptions(): ?Options
    {
        return $this->options;
    }
}
