<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvronException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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

    /** @throws AvronException */
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

    /** @throws AvronException */
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

    /** @throws AvronException */
    protected function throwUnexpectedToken(Token $token): never
    {
        $fmt = sprintf("unexpected %s", $token->getFormat());
        $this->throwException($token, $fmt, $token->getSymbol());
    }

    /** @throws AvronException */
    protected function throwUnexpectedTokenWithHint(Token $token, string $msg): never
    {
        $fmt = sprintf("unexpected %s, expected %%s", $token->getFormat());
        $this->throwException($token, $fmt, $token->getSymbol(), $msg);
    }

    /** @throws AvronException */
    protected function throwException(Token $token, string ...$msg): never
    {
        throw new AvronException(sprintf(
            "%s at line %d, column %d",
            sprintf(...$msg),
            $token->getLine(),
            $token->getColumn()
        ));
    }
}
