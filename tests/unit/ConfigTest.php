<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

use lengo\avron\Config;
use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\Config
 */
class ConfigTest extends TestCase
{
    public function testExistingConfigKey(): void
    {
        $config = Config::fromArray([Config::VERBOSITY_LEVEL => 42]);
        $this->assertSame(42, $config->get(Config::VERBOSITY_LEVEL));
    }

    public function testNonExistingConfigKey(): void
    {
        $config = Config::fromArray([]);
        $this->assertNull($config->get(Config::VERBOSITY_LEVEL));
    }
}
