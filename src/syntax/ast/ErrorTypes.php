<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

enum ErrorTypes: string
{
    case throws = "throws";
    case oneway = "oneway";

    public static function hasType(string $type): bool
    {
        return in_array($type, self::names(), true);
    }

    /**
     * @codeCoverageIgnore Inherent static initialization does not play well with coverage.
     * @return string[] The error type names.
     */
    public static function names(): array
    {
        /** @var string[] $names */
        static $names = [];

        if (sizeof($names)) {
            return $names;
        }
        return $names = array_column(ErrorTypes::cases(), "name");
    }
}
