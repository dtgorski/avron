<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Token
{
    public function __construct(
        private readonly int $type,
        private readonly int $line,
        private readonly int $column,
        private readonly string $load,
    ) {
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getSymbol(): string
    {
        return Token::symbol($this->getType());
    }

    public function getFormat(): string
    {
        return Token::format($this->getType());
    }

    public function getLoad(): string
    {
        return $this->load;
    }

    public function getLine(): int
    {
        return $this->line;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function is(int $type): bool
    {
        return $this->type === $type;
    }

    public function isNot(int $type): bool
    {
        return !$this->is($type);
    }

    public static function type(?int $type): string
    {
        return Token::TYPES[$type][0] ?? "?";
    }

    public static function symbol(?int $type): string
    {
        return Token::TYPES[$type][1] ?? "?";
    }

    public static function format(?int $type): string
    {
        switch ($type) {
            case Token::EOF:
            case Token::ERR:
            case Token::STRING:
            case Token::IDENT:
            case Token::NUMBER:
            case Token::SIGN:
            case Token::EXPO:
                return "%s";
        }
        return "'%s'";
    }

    // @formatter:off
    const
        EOF     = 0x00, // end of file/stream
        ERR     = 0x01, // error occurred
        AT      = 0x10, // @ annotation
        LT      = 0x11, // < less-than
        GT      = 0x12, // > greater-than
        EQ      = 0x13, // = equals sign
        DOT     = 0x14, // . dot
        TICK    = 0x15, // , comma
        COMMA   = 0x16, // , comma
        COLON   = 0x17, // : colon
        SEMICOL = 0x18, // ; semicolon
        DASH    = 0x19, // - dash / minus sign
        QMARK   = 0x1A, // ? question mark
        SLASH   = 0x20, // / forward slash
        COMLINE = 0x21, // // comment line
        COMBLCK = 0x22, // /* comment block
        LBRACK  = 0x23, // [ left square bracket
        RBRACK  = 0x24, // ] right square bracket
        LBRACE  = 0x25, // { left curly brace
        RBRACE  = 0x26, // } right curly brace
        LPAREN  = 0x27, // ( left parenthesis
        RPAREN  = 0x28, // ( right parenthesis
        STRING  = 0x30, // "...\"..."
        IDENT   = 0x31, // identifier
        NUMBER  = 0x40, // any number
        SIGN    = 0x41, // number exponent sign
        EXPO    = 0x42  // number exponent value
    ;

    private const TYPES = [
        //                 Type name  Symbol (for error message)
        Token::EOF     => ["EOF",     "end of file"],
        Token::ERR     => ["ERR",     "input"],
        Token::AT      => ["AT",      "@"],
        Token::LT      => ["LT",      "<"],
        Token::GT      => ["GT",      ">"],
        Token::DOT     => ["DOT",     "."],
        Token::TICK    => ["TICK",    "`"],
        Token::COMMA   => ["COMMA",   ","],
        Token::COLON   => ["COLON",   ":"],
        Token::SEMICOL => ["SEMICOL", ";"],
        Token::EQ      => ["EQ",      "="],
        Token::DASH    => ["DASH",    "-"],
        Token::QMARK   => ["QMARK",   "?"],
        Token::SLASH   => ["SLASH",   "/"],
        Token::COMLINE => ["COMLINE", "//"],
        Token::COMBLCK => ["COMBLCK", "/*"],
        Token::LBRACK  => ["LBRACK",  "["],
        Token::RBRACK  => ["RBRACK",  "]"],
        Token::LBRACE  => ["LBRACE",  "{"],
        Token::RBRACE  => ["RBRACE",  "}"],
        Token::LPAREN  => ["LPAREN",  "("],
        Token::RPAREN  => ["RPAREN",  ")"],
        Token::STRING  => ["STRING",  "string"],
        Token::IDENT   => ["IDENT",   "identifier"],
        Token::NUMBER  => ["NUMBER",  "number"],
        Token::SIGN    => ["SIGN",    "exponent sign"],
        Token::EXPO    => ["EXPO",    "exponent"],
    ];
}
