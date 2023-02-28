<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\LogicalType
 */
class LogicalTypeTest extends TestCase
{
    public function testLogicalType(): void
    {
        $this->assertSame("date", LogicalType::date->name);
        $this->assertSame("date", LogicalType::date->value);

        $this->assertSame("time_ms", LogicalType::time_ms->name);
        $this->assertSame("time_ms", LogicalType::time_ms->value);

        $this->assertSame("timestamp_ms", LogicalType::timestamp_ms->name);
        $this->assertSame("timestamp_ms", LogicalType::timestamp_ms->value);

        $this->assertSame("local_timestamp_ms", LogicalType::local_timestamp_ms->name);
        $this->assertSame("local_timestamp_ms", LogicalType::local_timestamp_ms->value);

        $this->assertSame("uuid", LogicalType::uuid->name);
        $this->assertSame("uuid", LogicalType::uuid->value);

        $this->assertEquals(LogicalType::names(), LogicalType::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(LogicalType::hasType("date"));
        $this->assertTrue(LogicalType::hasType("time_ms"));
        $this->assertTrue(LogicalType::hasType("timestamp_ms"));
        $this->assertTrue(LogicalType::hasType("local_timestamp_ms"));
        $this->assertTrue(LogicalType::hasType("uuid"));
    }
}
