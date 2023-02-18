<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

interface Cursor
{
    public function peek(): Token;

    public function next(): Token;

    public function getCommentQueue(): CommentsReadQueue;
}
