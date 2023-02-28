<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Config
{
    const COMPILER_TARGET = "COMPILER_TARGET";
    const EXCLUDE_PATTERNS = "EXCLUDE_PATTERNS";
    const OUTPUT_DIRECTORY = "OUTPUT_DIRECTORY";
    const OVERWRITE_FILES = "OVERWRITE_FILES";
    const PERFORM_DRY_RUN = "PERFORM_DRY_RUN";
    const VERBOSITY_LEVEL = "VERBOSITY_LEVEL";

    public static function fromDefault(): Config
    {
        return self::fromArray([]);
    }

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

    /** @param array<mixed> $config */
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

        $want = gettype($this->config[$key]);
        $have = gettype($val);

        if ($want === $have) {
            $this->config[$key] = $val;
            return $this;
        }

        throw new \InvalidArgumentException(
            sprintf("incompatible types for %s (want %s, have %s)", $key, $want, $have)
        );
    }

    /** @return array<mixed> */
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
