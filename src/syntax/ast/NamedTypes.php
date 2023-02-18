<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

enum NamedTypes: string
{
    case enum = "enum";
    case error = "error";
    case fixed = "fixed";
    case record = "record";

    public static function hasType(string $type): bool
    {
        return in_array($type, self::names(), true);
    }

    /** @return string[] The named type names. */
    public static function names(): array
    {
        /** @var string[] $names */
        static $names = [];

        if (sizeof($names)) {
            return $names;
        }
        return $names = array_column(NamedTypes::cases(), "name");
    }
}
