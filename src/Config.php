<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/** @template-implements \IteratorAggregate<string,string> */
class Config implements IteratorAggregate
{
    const COMPILER_TARGET = "COMPILER_TARGET";
    const EXCLUDE_PATTERNS = "EXCLUDE_PATTERNS";
    const OUTPUT_DIRECTORY = "OUTPUT_DIRECTORY";
    const OVERWRITE_FILES = "OVERWRITE_FILES";
    const PERFORM_DRY_RUN = "PERFORM_DRY_RUN";
    const VERBOSITY_LEVEL = "VERBOSITY_LEVEL";

    public static function fromArray(array $config): Config
    {
        return new Config(array_merge([
            self::COMPILER_TARGET => "avdl",
            self::EXCLUDE_PATTERNS => [],
            self::OUTPUT_DIRECTORY => "",
            self::OVERWRITE_FILES => false,
            self::PERFORM_DRY_RUN => false,
            self::VERBOSITY_LEVEL => 0,
        ], $config));
    }

    private function __construct(private array $config)
    {
    }

    public function get(string $key): mixed
    {
        return $this->config[$key] ?? null;
    }

    public function set(string $key, mixed $val): Config
    {
        if (!array_key_exists($key, $this->config)) {
            $this->config[$key] = $val;
            return $this;
        }
        if (gettype($this->config[$key]) === gettype($val)) {
            $this->config[$key] = $val;
            return $this;
        }
        throw new \InvalidArgumentException(
            sprintf("incompatible types for %s", $key)
        );
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->config);
    }

    public function asArray(): array
    {
        return $this->config;
    }

    public function mustPerformDryRun(): bool
    {
        return (bool)$this->get(self::PERFORM_DRY_RUN);
    }

    public function verbosityLevel(): int
    {
        return (int)$this->get(self::VERBOSITY_LEVEL);
    }
}
