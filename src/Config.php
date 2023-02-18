<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

class Config
{
    const VERBOSITY_LEVEL = "verbosity-level";
    const PERFORM_DRY_RUN = "perform-dry-run";

    public static function fromArray(array $config): Config
    {
        return new Config($config);
    }

    private function __construct(private readonly array $config)
    {
    }

    public function get(string $key): mixed
    {
        return $this->config[$key] ?? null;
    }
}
