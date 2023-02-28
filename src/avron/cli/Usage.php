<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Usage
{
    public function __construct(
        private readonly string $executable,
        private readonly Manifest $manifest
    ) {
    }

    public function renderGlobalHelp(Options $options, Commands $commands): void
    {
        $this->renderHeader();

        printf("Usage:\n");
        printf("    %s [OPTION...] [COMMAND [OPTION...] FILE...] \n", $this->executable);

        if ($options->size()) {
            printf("\n");
            printf("Options:\n");

            list($lft, $rgt) = $this->createOptionColumns($options);
            for ($i = 0, $n = sizeof($lft); $i < $n; $i++) {
                printf("    %s\t\t%s\n", $lft[$i], $rgt[$i]);
            }
        }

        if ($commands->size()) {
            printf("\n");
            printf("Commands:\n");

            /** @var Command $command */
            foreach ($commands as $command) {
                printf("    %s %s\n", $command->getName(), $command->getDescription());
            }
        }

        $this->renderFooter();
    }

    public function renderCommandHelp(Command $command): void
    {
    }

    private function createOptionColumns(Options $options): array
    {
        $lft = [];
        $rgt = [];
        $mayHaveArgName = [Option::MODE_ARG_SINGLE, Option::MODE_ARG_MULTIPLE];

        foreach ($options as $option) {
            $name = $this->createOptionName($option);
            $desc = $this->createOptionDesc($option);

            if (in_array($option->get(Option::OPT_MODE), $mayHaveArgName)) {
                $name = sprintf("%s <%s>", $name, $option->get(Option::OPT_ARGN));
            }
            $lft[] = $name;
            $rgt[] = $desc;
        }
        return [$lft, $rgt];
    }

    private function createOptionName(Option $option): string
    {
        $short = $option->get(Option::OPT_SHORT);
        $long = $option->get(Option::OPT_LONG);

        if ($short) {
            $str = sprintf("-%s", $short);
            $str .= $long ? ", " : "";
        } else {
            $str = "    ";
        }
        if ($long) {
            $str .= sprintf("--%s", $long);
        }
        return $str;
    }

    private function createOptionDesc(Option $option): string
    {
        $str = $option->get(Option::OPT_DESC);
        return $str;
    }

    private function renderHeader(): void
    {
        $mani = $this->manifest;
        printf("%s %s · %s\n", $mani->getName(), $mani->getVersion(), $mani->getDescription());
        printf("\n");
    }

    private function renderFooter(): void
    {
        printf("\n");
        printf("Copyright (C) Daniel T. Gorski · <https://github.com/dtgorski/avron>\n");
    }
}
