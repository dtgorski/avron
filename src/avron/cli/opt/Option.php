<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Option
{
    const OPT_SHORT /**/ = "OPT_SHORT";
    const OPT_LONG /* */ = "OPT_LONG";
    const OPT_DESC /* */ = "OPT_DESC";
    const OPT_MODE /* */ = "OPT_MODE";
    const OPT_TEST /* */ = "OPT_TEST";
    const OPT_ARGN /* */ = "OPT_ARGN";
    const OPT_VALUE /**/ = "OPT_VALUE";

    // Utility Syntax Guidelines advise against optional option arguments.
    // <https://pubs.opengroup.org/onlinepubs/9699919799/basedefs/V1_chap12.html#tag_12_02>
    const MODE_ARG_NONE /*    */ = "ARG_NONE";
    const MODE_ARG_SINGLE /*  */ = "ARG_SINGLE";
    const MODE_ARG_MULTIPLE /**/ = "ARG_MULTIPLE";

    public static function fromMap(array $map): Option
    {
        return new Option(array_merge([
            self::OPT_SHORT => "",
            self::OPT_LONG => "",
            self::OPT_DESC => "",
            self::OPT_MODE => self::MODE_ARG_NONE,
            self::OPT_TEST => fn(string $_): bool => true,
            self::OPT_ARGN => "args",
            self::OPT_VALUE => "",
        ], $map));
    }

    public static function fromOption(Option $option, array $map): Option
    {
        return new Option(array_merge([
            self::OPT_SHORT => $option->get(self::OPT_SHORT),
            self::OPT_LONG => $option->get(self::OPT_LONG),
            self::OPT_DESC => $option->get(self::OPT_DESC),
            self::OPT_MODE => $option->get(self::OPT_MODE),
            self::OPT_TEST => $option->get(self::OPT_TEST),
            self::OPT_ARGN => $option->get(self::OPT_ARGN),
            self::OPT_VALUE => $option->get(self::OPT_VALUE),
        ], $map));
    }

    private function __construct(private readonly array $map)
    {
    }

    public function get(string $key): mixed
    {
        return $this->map[$key] ?? null;
    }
}
