<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Core\ArrayList;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @extends  ArrayList<Option>
 */
class Options extends ArrayList
{
    /** @param Option[] $options */
    public static function fromArray(array $options): Options
    {
        // TODO: check uniqueness of short & long options
        // TODO: merge multiarg options to array value
        return new self($options);
    }

    public function getByName(string $name): Option|null
    {
        foreach ($this->asArray() as $option) {
            if ($name === $option->get(Option::OPT_SHORT)) {
                return $option;
            }
            if ($name === $option->get(Option::OPT_LONG)) {
                return $option;
            }
        }
        return null;
    }
}
