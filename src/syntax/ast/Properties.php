<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Core\ArrayList;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @extends  ArrayList<Property>
 */
class Properties extends ArrayList implements \JsonSerializable
{
    /** @param Property[] $properties */
    public static function fromArray(array $properties): Properties
    {
        return new Properties($properties);
    }

    public function getByName(string $name): Property|null
    {
        foreach ($this->asArray() as $property) {
            if ($name === $property->getName()) {
                return $property;
            }
        }
        return null;
    }

    public function jsonSerialize(): object
    {
        return (object)$this->asArray();
    }
}
