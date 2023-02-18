<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\AvroException;

class NodeNamespace implements \Stringable
{
    /** @var string[] $hierarchy */
    private readonly array $hierarchy;

    /** @throws AvroException */
    public static function fromString(string $namespace): NodeNamespace
    {
        return new NodeNamespace($namespace);
    }

    /** @throws AvroException */
    private function __construct(private readonly string $namespace)
    {
        // Empty namespaces allowed per specification.
        if ($namespace !== "") {
            if (!preg_match(self::$regex, $namespace)) {
                throw new AvroException(sprintf("invalid namespace '%s'", $namespace));
            }
        }
        $this->hierarchy = explode(".", $namespace);
    }

    /** @return string[] */
    public function getHierarchy(): array
    {
        return $this->hierarchy;
    }

    public function __toString(): string
    {
        return $this->namespace;
    }

    private static string $regex = "/^[a-z_]([a-z0-9_]*)(\.[a-z_][a-z0-9_]*)*$/i";
}
