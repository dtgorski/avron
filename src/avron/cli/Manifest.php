<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Manifest
{
    public static function fromParams(
        string $name,
        string $version,
        string $description,
    ): Manifest {
        return new Manifest($name, $version, $description);
    }

    private function __construct(
        private readonly string $name,
        private readonly string $version,
        private readonly string $description
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
