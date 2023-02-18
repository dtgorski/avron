<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\LogicalTypes
 */
class LogicalTypesTest extends TestCase
{
    public function testLogicalType(): void
    {
        $this->assertSame("date", LogicalTypes::date->name);
        $this->assertSame("date", LogicalTypes::date->value);

        $this->assertSame("time_ms", LogicalTypes::time_ms->name);
        $this->assertSame("time_ms", LogicalTypes::time_ms->value);

        $this->assertSame("timestamp_ms", LogicalTypes::timestamp_ms->name);
        $this->assertSame("timestamp_ms", LogicalTypes::timestamp_ms->value);

        $this->assertSame("local_timestamp_ms", LogicalTypes::local_timestamp_ms->name);
        $this->assertSame("local_timestamp_ms", LogicalTypes::local_timestamp_ms->value);

        $this->assertSame("uuid", LogicalTypes::uuid->name);
        $this->assertSame("uuid", LogicalTypes::uuid->value);

        $this->assertEquals(LogicalTypes::names(), LogicalTypes::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(LogicalTypes::hasType("date"));
        $this->assertTrue(LogicalTypes::hasType("time_ms"));
        $this->assertTrue(LogicalTypes::hasType("timestamp_ms"));
        $this->assertTrue(LogicalTypes::hasType("local_timestamp_ms"));
        $this->assertTrue(LogicalTypes::hasType("uuid"));
    }
}
