<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Api\Visitable;
use Avron\Api\Visitor;
use Exception;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Usage implements Visitor
{
    private int $step = 0;

    public function __construct(
        private readonly Manifest $manifest,
        private readonly Renderer $renderer
    ) {
    }

    /**
     * @param Command $command Handler tree reflecting the command hierarchy.
     * @throws Exception
     */
    public function render(Command $command): void
    {
//        $this->renderer->writeParagraph(
//            sprintf("Usage: %s %s", $this->manifest->getName(), $command->getParameters())
//        );

        $command->accept($this);

        $this->renderer->flush();
    }

    public function visit(Visitable $visitable): bool
    {
        if (!$visitable instanceof Command) {
            return true;
        }

        $indent = self::spaces($this->step << 2);

        $invocation = sprintf(
            "%s%s %s",
            $indent,
            $visitable->getPath(),
            #$visitable->getPath(),
            self::dim($visitable->getParameters())
        );
        $description = sprintf("%s%s", $indent, $visitable->getDescription());

        if ($this->step != 0) {
     #       $this->renderer->writeParagraph("");
        }

        $this->renderer->writeParagraph($invocation);
#        $this->renderer->writeParagraph($description);

        $this->renderOptions($visitable);
        $this->renderCommands($visitable);

        $this->step++;

        return true;
    }

    public function leave(Visitable $visitable): void
    {
        $this->step--;
    }

    private function renderOptions(Command $command): void
    {
        if (!$command->options()->size()) {
            return;
        }
        if ($this->step == 0) {
            $this->renderer->writeParagraph("\nOptions:");
        }

        $indent = self::spaces(($this->step + 1) << 2);

        foreach ($command->options() as $option) {
            $this->renderer->writeColumns(
                sprintf("%s%s", $indent, $this->createOptionName($option)),
                $option->get(Option::OPT_DESC)
            );
        }
    }

    private function renderCommands(Command $command): void
    {
        if (!sizeof($command->childNodes())) {
            return;
        }
        if ($this->step == 0) {
            $this->renderer->writeParagraph("\nCommands:");
        }

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

    private static function spaces(int $n): string
    {
        return str_repeat(" ", $n);
    }

    private static function em(string $s): string
    {
        $isTTY = fstat(STDOUT)["mode"] & 8192; // POSIX_S_IFCHR
        return $isTTY ? "\033[1m$s\033[0m" : $s;
    }

    private static function dim(string $s): string
    {
        $isTTY = fstat(STDOUT)["mode"] & 8192; // POSIX_S_IFCHR
        return $isTTY ? "\033[2m$s\033[0m" : $s;
    }
}
