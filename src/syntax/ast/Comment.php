<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
