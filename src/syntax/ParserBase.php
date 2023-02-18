<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvroException;

abstract class ParserBase
{
    public function __construct(private readonly Cursor $cursor)
    {
    }

    public function getCursor(): Cursor
    {
        return $this->cursor;
    }

    public function peek(): Token
    {
        return $this->cursor->peek();
    }

    public function next(): Token
    {
        return $this->cursor->next();
    }

    public function expect(int $tokenType, string ...$accepted): bool
    {
        $token = $this->peek();

        if ($token->is(Token::EOF) && $tokenType != Token::EOF) {
            return false;
        }
        if (!$token->is($tokenType)) {
            return false;
        }
        if (sizeof($accepted) === 0) {
            return true;
        }
        return in_array($token->getLoad(), $accepted, true);
    }

    /** @throws AvroException */
    public function consumeWithHint(int $tokenType, string $hint, string ...$accepted): Token
    {
        $token = $this->peek();

        if ($token->is(Token::EOF) && $tokenType != Token::EOF) {
            $this->throwUnexpectedTokenWithHint($token, $hint);
        }
        if (!$token->is($tokenType)) {
            $this->throwUnexpectedTokenWithHint($token, $hint);
        }
        if (sizeof($accepted) && !in_array($token->getLoad(), $accepted, true)) {
            $this->throwUnexpectedTokenWithHint($token, $hint);
        }
        return $this->next();
    }

    /** @throws AvroException */
    public function consume(int $tokenType, string ...$accepted): Token
    {
        $token = $this->peek();

        if ($token->is(Token::EOF) && $tokenType != Token::EOF) {
            $this->throwUnexpectedToken($token);
        }
        if (!$token->is($tokenType)) {
            $this->throwUnexpectedToken($token);
        }
        if (sizeof($accepted) && !in_array($token->getLoad(), $accepted, true)) {
            $this->throwUnexpectedToken($token);
        }
        return $this->next();
    }

    /** @throws AvroException */
    protected function throwUnexpectedToken(Token $token): never
    {
        $fmt = sprintf("unexpected %s", $token->getFormat());
        $this->throwException($token, $fmt, $token->getSymbol());
    }

    /** @throws AvroException */
    protected function throwUnexpectedTokenWithHint(Token $token, string $msg): never
    {
        $fmt = sprintf("unexpected %s, expected %%s", $token->getFormat());
        $this->throwException($token, $fmt, $token->getSymbol(), $msg);
    }

    /** @throws AvroException */
    protected function throwException(Token $token, string ...$msg): never
    {
        throw new AvroException(sprintf(
            "%s at line %d, column %d",
            sprintf(...$msg),
            $token->getLine(),
            $token->getColumn()
        ));
    }
}
