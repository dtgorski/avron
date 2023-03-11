<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Core\ArrayList;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @extends  ArrayList<Comment>
 */
class Comments extends ArrayList {

    /** @param Comment[] $comments */
    public static function fromArray(array $comments): Comments
    {
        return new Comments($comments);
    }
}
