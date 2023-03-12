<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Api\Writer;
use Avron\StandardWriter;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Renderer
{
    private array $cols = [];

    private int $lftWidth = 0;
    private int $maxWidth = 96;

    public function __construct(
        private readonly Writer $writer = new StandardWriter(STDOUT)
    ) {
    }

    public function writeParagraph(string $string): void
    {
        $this->writeColumns($string);
    }

    public function writeColumns(string $lft, string $rgt = null): void
    {
        $this->lftWidth = is_string($rgt) ? max($this->lftWidth, strlen($lft)) : $this->lftWidth;
        $this->cols[] = [$lft, $rgt];
    }

    public function flush(): void
    {
        $lftWidth = $this->lftWidth + 2;
        $rgtWidth = $this->maxWidth - $lftWidth;

        $spaces = str_repeat(" ", $lftWidth);

        foreach ($this->cols as $col) {
            $lft = $col[0];
            $rgt = $col[1];

            if (is_string($rgt)) {
                $lft = sprintf("%s%s", $lft, $spaces);
                $lft = substr($lft, 0, $lftWidth);
                $rgt = wordwrap($rgt, $rgtWidth, sprintf("\n%s", $spaces), true);
                $this->writer->write($lft, $rgt, "\n");
                continue;
            }

            $lft = wordwrap($lft, $this->maxWidth, sprintf("\n%s", $spaces));
            $this->writer->write($lft, "\n");
        }
    }
}
