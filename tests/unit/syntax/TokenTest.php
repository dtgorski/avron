<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\Token
 */
class TokenTest extends TestCase
{
    public function testIntegrity(): void
    {
        $token = new Token(1, 2, 3, "4");

        $this->assertSame(1, $token->getType());
        $this->assertSame(2, $token->getLine());
        $this->assertSame(3, $token->getColumn());
        $this->assertSame("4", $token->getLoad());

        $this->assertTrue($token->is(1));
        $this->assertTrue($token->isNot(0));

        $this->assertSame(1, $token->getType());
        $this->assertSame("input", $token->getSymbol());
        $this->assertSame("%s", $token->getFormat());

        $this->assertSame("ERR", Token::type(1));
        $this->assertSame("input", Token::symbol(1));

        $this->assertIsString(Token::format(1));
        $this->assertIsString(Token::format(42));
    }
}
