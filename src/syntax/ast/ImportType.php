<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
enum ImportType: string
{
    case idl = "idl";
    case protocol = "protocol";
    case schema = "schema";

    public static function hasType(string $type): bool
    {
        return in_array($type, self::names(), true);
    }

    /**
     * @codeCoverageIgnore Inherent static initialization does not play well with coverage.
     * @return string[] The import type names.
     */
    public static function names(): array
    {
        /** @var string[] $names */
        static $names = [];

        if (sizeof($names)) {
            return $names;
        }
        return $names = array_column(ImportType::cases(), "name");
    }
}
