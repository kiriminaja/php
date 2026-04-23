<?php

namespace Tests\Utils;

use KiriminAja\Utils\Volumetric;
use PHPUnit\Framework\TestCase;

class VolumetricTest extends TestCase
{
    public function testEmpty(): void
    {
        $this->assertSame(
            ['length' => 0, 'width' => 0, 'height' => 0],
            Volumetric::calculate([])
        );
    }

    public function testSingleItem(): void
    {
        $this->assertSame(
            ['length' => 10, 'width' => 5, 'height' => 3],
            Volumetric::calculate([['qty' => 1, 'length' => 10, 'width' => 5, 'height' => 3]])
        );
    }

    public function testVerticalWins(): void
    {
        $this->assertSame(
            ['length' => 10, 'width' => 10, 'height' => 4],
            Volumetric::calculate([['qty' => 2, 'length' => 10, 'width' => 10, 'height' => 2]])
        );
    }

    public function testHorizontalWins(): void
    {
        $this->assertSame(
            ['length' => 20, 'width' => 10, 'height' => 10],
            Volumetric::calculate([
                ['qty' => 5, 'length' => 2,  'width' => 10, 'height' => 10],
                ['qty' => 1, 'length' => 10, 'width' => 1,  'height' => 1],
            ])
        );
    }

    public function testSideWins(): void
    {
        $this->assertSame(
            ['length' => 10, 'width' => 20, 'height' => 10],
            Volumetric::calculate([
                ['qty' => 5, 'length' => 10, 'width' => 2,  'height' => 10],
                ['qty' => 1, 'length' => 1,  'width' => 10, 'height' => 1],
            ])
        );
    }

    public function testQtyZeroTreatedAsOne(): void
    {
        $this->assertSame(
            ['length' => 10, 'width' => 5, 'height' => 3],
            Volumetric::calculate([['qty' => 0, 'length' => 10, 'width' => 5, 'height' => 3]])
        );
    }
}
