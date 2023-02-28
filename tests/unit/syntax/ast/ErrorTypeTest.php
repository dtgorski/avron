<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ErrorType
 */
class ErrorTypeTest extends TestCase
{
    public function testErrorType(): void
    {
        $this->assertSame("throws", ErrorType::throws->name);
        $this->assertSame("throws", ErrorType::throws->value);

        $this->assertSame("oneway", ErrorType::oneway->name);
        $this->assertSame("oneway", ErrorType::oneway->value);

        $this->assertEquals(ErrorType::names(), ErrorType::names());
    }

    public function testHasType(): void
    {
        $this->assertTrue(ErrorType::hasType("throws"));
        $this->assertTrue(ErrorType::hasType("throws"));
    }
}
