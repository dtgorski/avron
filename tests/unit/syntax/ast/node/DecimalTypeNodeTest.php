<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\DecimalTypeNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 */
class DecimalTypeNodeTest extends TestCase
{
    public function testGetPrecision(): void
    {
        $type = new DecimalTypeNode(10, 2);
        $this->assertSame(10, $type->getPrecision());
    }

    public function testGetScale(): void
    {
        $type = new DecimalTypeNode(10, 2);
        $this->assertSame(2, $type->getScale());
    }

    // From <https://avro.apache.org/docs/1.11.1/specification/_print/#decimal>
    //
    // The following attributes are supported:
    //
    //   * precision, a JSON integer representing the (maximum) precision of decimals stored in this type (required).
    //   * scale, a JSON integer representing the scale (optional). If not specified the scale is 0.
    //
    // Precision must be a positive integer greater than zero.
    // Scale must be zero or a positive integer less than or equal to the precision.

    public function testThrowExceptionOnInvalidPrecision(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DecimalTypeNode(0, 2);
    }

    public function testThrowExceptionOnInvalidScale(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DecimalTypeNode(10, -1);
    }

    public function testThrowExceptionWhenScaleGraterThanPrecision(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DecimalTypeNode(1, 2);
    }
}
