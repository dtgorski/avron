<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

interface SourceFile extends \Stringable
{
    public function getPath(): string;

    public function getName(): string;

    public function getDir(): string;
}
