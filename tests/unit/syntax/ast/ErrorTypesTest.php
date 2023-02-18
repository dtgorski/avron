<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ErrorTypes
 */
class ErrorTypesTest extends TestCase
{
    public function testErrorType(): void
    {
        $this->assertSame("throws", ErrorTypes::throws->name);
        $this->assertSame("throws", ErrorTypes::throws->value);

        $this->assertSame("oneway", ErrorTypes::oneway->name);
        $this->assertSame("oneway", ErrorTypes::oneway->value);

        $this->assertEquals(ErrorTypes::names(), ErrorTypes::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(ErrorTypes::hasType("throws"));
        $this->assertTrue(ErrorTypes::hasType("throws"));
    }
}
