<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use InvalidArgumentException;
use lengo\avron\api\ByteReader;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ByteStreamReader implements ByteReader
{
    private int $line = 1;
    private int $column = 0;
    private int $byte = 0;

    /**
     * @param resource $stream
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __construct(private $stream)
    {
        if (!is_resource($stream)) {
            throw new InvalidArgumentException();
        }
    }

    public function readByte(): int
    {
        switch ($this->byte) {
            case 0x0A:
                $this->line++;
                $this->column = 1;
                break;
            case 0x09:
                $this->column += (4 - (($this->column - 1) % 4));
                break;
            default:
                $this->column++;
        }

        /** @var string $byte calms static analysis down. */
        $byte = fread($this->stream, 1);

        return $this->byte = ord($byte);
    }

    public function getLine(): int
    {
        return $this->line;
    }

    public function getColumn(): int
    {
        return $this->column;
    }
}
