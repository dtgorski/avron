<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ImportTypes
 */
class ImportTypesTest extends TestCase
{
    public function testImportType(): void
    {
        $this->assertSame("idl", ImportTypes::idl->name);
        $this->assertSame("idl", ImportTypes::idl->value);

        $this->assertSame("protocol", ImportTypes::protocol->name);
        $this->assertSame("protocol", ImportTypes::protocol->value);

        $this->assertSame("schema", ImportTypes::schema->name);
        $this->assertSame("schema", ImportTypes::schema->value);

        $this->assertEquals(ImportTypes::names(), ImportTypes::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(ImportTypes::hasType("idl"));
        $this->assertTrue(ImportTypes::hasType("protocol"));
        $this->assertTrue(ImportTypes::hasType("schema"));
    }
}
