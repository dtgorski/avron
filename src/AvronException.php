<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use Exception;

class AvronException extends Exception
{
    public function getError(): string
    {
        return sprintf("avron error: %s", parent::getMessage());
    }
}
