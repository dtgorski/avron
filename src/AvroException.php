<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use Exception;

class AvroException extends Exception
{
    public function getError(): string
    {
        return sprintf("avro exception: %s", parent::getMessage());
    }
}
