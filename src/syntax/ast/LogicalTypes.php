<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

enum LogicalTypes: string
{
    case date = "date";
    case time_ms = "time_ms";
    case timestamp_ms = "timestamp_ms";
    case local_timestamp_ms = "local_timestamp_ms";
    case uuid = "uuid";

    public static function hasType(string $type): bool
    {
        return in_array($type, self::names(), true);
    }

    /** @return string[] The logical type names. */
    public static function names(): array
    {
        /** @var string[] $names */
        static $names = [];

        if (sizeof($names)) {
            return $names;
        }
        return $names = array_column(LogicalTypes::cases(), "name");
    }
}
