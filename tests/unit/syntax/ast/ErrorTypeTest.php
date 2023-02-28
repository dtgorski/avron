<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\ErrorType
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
