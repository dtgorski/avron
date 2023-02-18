<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

class Comment
{
    public function __construct(private readonly string $text)
    {
    }

    public static function fromToken(Token $token): Comment
    {
        $text = $token->getLoad();

        $text = preg_replace("/^(\s*)\/\*\*?/m", "", $text);
        $text = preg_replace("/\*\//m", "", $text);
        $text = trim($text);
        $text = preg_replace("/^\s+/m", "", $text);
        $text = preg_replace("/^\*\s/m", "", $text);

        return new Comment($text);
    }

    public function getText(): string
    {
        return $this->text;
    }
}
