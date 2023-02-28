<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Config
 */
class ConfigTest extends TestCase
{
    public function testExistingConfigKey(): void
    {
        $config = Config::fromArray([Config::VERBOSITY_LEVEL => 42]);
        $this->assertSame(42, $config->get(Config::VERBOSITY_LEVEL));
    }

    public function testDefaultConfigKey(): void
    {
        $config = Config::fromArray([]);
        $this->assertSame(0, $config->get(Config::VERBOSITY_LEVEL));
    }

    public function testNonExistingConfigKey(): void
    {
        $config = Config::fromArray([]);
        $this->assertNull($config->get("foo"));
    }
}
