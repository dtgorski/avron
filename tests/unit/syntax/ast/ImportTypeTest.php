<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ImportType
 */
class ImportTypeTest extends TestCase
{
    public function testImportType(): void
    {
        $this->assertSame("idl", ImportType::idl->name);
        $this->assertSame("idl", ImportType::idl->value);

        $this->assertSame("protocol", ImportType::protocol->name);
        $this->assertSame("protocol", ImportType::protocol->value);

        $this->assertSame("schema", ImportType::schema->name);
        $this->assertSame("schema", ImportType::schema->value);

        $this->assertEquals(ImportType::names(), ImportType::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(ImportType::hasType("idl"));
        $this->assertTrue(ImportType::hasType("protocol"));
        $this->assertTrue(ImportType::hasType("schema"));
    }
}
