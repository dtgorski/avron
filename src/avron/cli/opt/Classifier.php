<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Classifier
{
    /**
     * Put input arguments into a more processable form.
     *
     * @param string[] $array
     * @return Arguments
     */
    public static function parseArguments(array $array): Arguments
    {
        $args = [];
        $rest = false;

        foreach ($array as $arg) {
            if (($arg = trim($arg)) == "") {
                continue;
            }
            if ($rest) {
                $args[] = Argument::fromOperand($arg);
                continue;
            }
            if ($arg == "--") {
                $rest = true;
                continue;
            }

            // --foo-option[=bar], consume if pattern matches.
            if (preg_match("/^--([a-z0-9]+[a-z0-9-]*[a-z0-9])(=\S*)?$/iS", $arg, $m)) {
                $value = $m[1];
                $preset = isset($m[2]) ? substr($m[2], 1) : null;
                $args[] = Argument::fromOption($value, $preset);
                continue;
            }

            // -fLAGs[=bar], split into individual flags, last gets value.
            if (preg_match("/^-([a-z0-9]+)(=\S*)?$/iS", $arg, $m)) {
                $values = str_split($m[1]);
                $preset = isset($m[2]) ? substr($m[2], 1) : null;

                for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
                    $args[] = Argument::fromOption($values[$i], ($i === $n - 1) ? $preset : null);
                }
                continue;
            }

            // Option argument, rest operand or broken.
            $args[] = Argument::fromOperand($arg);
        }

        return Arguments::fromArray($args);
    }

    private function __construct()
    {
    }
}
