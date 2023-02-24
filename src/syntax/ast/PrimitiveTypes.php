<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
enum PrimitiveTypes: string
{
    case boolean = "boolean";
    case bytes = "bytes";
    case int = "int";
    case string = "string";
    case float = "float";
    case double = "double";
    case long = "long";
    case null = "null";

    public static function hasType(string $type): bool
    {
        return in_array($type, self::names(), true);
    }

    /**
     * @codeCoverageIgnore Inherent static initialization does not play well with coverage.
     * @return string[] The primitive type names.
     */
    public static function names(): array
    {
        /** @var string[] $names */
        static $names = [];

        if (sizeof($names)) {
            return $names;
        }
        return $names = array_column(PrimitiveTypes::cases(), "name");
    }
}
