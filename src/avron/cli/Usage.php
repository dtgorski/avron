<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Usage
{
    private const ARGS = "[OPTION...] [COMMAND [OPTION...] FILE...]";

    public function __construct(
        private readonly string $executable,
        private readonly Manifest $manifest
    ) {
    }

    public function renderUsage(Options $options, Commands $commands): void
    {
        printf("Usage: %s %s\n", self::em($this->executable), self::ARGS);
        printf("\n");
        printf("%s\n", $this->manifest->getDescription());

        $leftWidth = $this->calcOptionNamesMaxWidth($options);

        if ($options->size()) {
            printf("\n");
            printf("Options:\n");
            $this->renderOptions($options, 4, $leftWidth);
        }

        foreach ($commands as $command) {
            $max = $this->calcOptionNamesMaxWidth($command->getOptions());
            $leftWidth = max($max, $leftWidth);
        }

        if ($commands->size()) {
            printf("\n");
            printf("Commands:\n");
            $this->renderCommands($commands, $leftWidth);
        }

        $version = $this->manifest->getVersion();
        $sources = "https://github.com/dtgorski/avron";

        printf("\n");
        printf("avron %s - Sources: <%s>\n", $version, $sources);
    }

    public function renderCommandUsage(Command $command): void
    {
    }

    private function renderOptions(Options $options, int $indent, int $leftWidth): void
    {
        $spaces = fn(int $n): string => str_repeat(" ", $n);
        $padding = $spaces($indent + $leftWidth + 2);
        $rightWidth = 96 - $leftWidth;

        foreach ($options as $option) {
            $name = $this->createOptionName($option);
            $desc = (string)$option->get(Option::OPT_DESC);

            $lft = sprintf("%s%s%s", $spaces($indent), $name, $padding);
            $lft = substr($lft, 0, strlen($padding));
            $rgt = wordwrap($desc, $rightWidth, sprintf("\n%s", $padding));

            printf("%s%s\n", $lft, $rgt);
        }
    }

    private function renderCommands(Commands $commands, int $leftWidth): void
    {
        foreach ($commands as $command) {
            $name = self::em($command->getName());
            $args = $command->getUsageArgs();
            $desc = $command->getDescription();

            printf($commands->asArray()[0] === $command ? "" : "\n");
            printf("    %s %s / %s\n", $name, $args, $desc);

            $this->renderOptions($command->getOptions(), 8, $leftWidth);
        }
    }

    private function calcOptionNamesMaxWidth(Options $options): int
    {
        $max = 0;
        foreach ($options as $option) {
            $max = max(strlen($this->createOptionName($option)), $max);
        }
        return $max;
    }

    private function createOptionName(Option $option): string
    {
        $shrt = (string)$option->get(Option::OPT_SHORT);
        $long = (string)$option->get(Option::OPT_LONG);
        $name = $shrt ? sprintf("-%s%s", $shrt, $long ? ", " : "") : "    ";
        $name = $long ? sprintf("%s--%s", $name, $long) : $name;

        $hasArgName = fn(Option $option): bool => in_array(
            $option->get(Option::OPT_MODE),
            [Option::MODE_ARG_SINGLE, Option::MODE_ARG_MULTIPLE],
            true
        );
        if ($hasArgName($option)) {
            $name = sprintf("%s <%s>", $name, (string)$option->get(Option::OPT_ARGN));
        }
        return $name;
    }

    private static function em(string $s): string
    {
        $isTTY = fstat(STDOUT)["mode"] & 8192; // POSIX_S_IFCHR
        return $isTTY ? "\033[1m$s\033[0m" : $s;
    }
}
