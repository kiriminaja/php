<?php

namespace KiriminAja\Utils;

class Volumetric
{
    /**
     * Calculate the smallest bounding box that fits all items by trying
     * three stacking strategies (vertical, horizontal, side-by-side) and
     * returning the dimensions with the smallest volume.
     *
     * Each item is an associative array with the keys:
     *   - qty:    int (>= 1; values < 1 are treated as 1)
     *   - length: int|float
     *   - width:  int|float
     *   - height: int|float
     *
     * @param array<int, array{qty?: int|float, length?: int|float, width?: int|float, height?: int|float}> $items
     * @return array{length: int|float, width: int|float, height: int|float}
     */
    public static function calculate(array $items): array
    {
        if (empty($items)) {
            return ['length' => 0, 'width' => 0, 'height' => 0];
        }

        $lVert = 0; $wVert = 0; $hVert = 0;
        $lHor  = 0; $wHor  = 0; $hHor  = 0;
        $lSide = 0; $wSide = 0; $hSide = 0;

        foreach ($items as $it) {
            $qty = (int)($it['qty'] ?? 1);
            if ($qty < 1) $qty = 1;
            $l = $it['length'] ?? 0;
            $w = $it['width']  ?? 0;
            $h = $it['height'] ?? 0;

            $hVert += $h * $qty;
            if ($l > $lVert) $lVert = $l;
            if ($w > $wVert) $wVert = $w;

            $lHor += $l * $qty;
            if ($h > $hHor) $hHor = $h;
            if ($w > $wHor) $wHor = $w;

            $wSide += $w * $qty;
            if ($h > $hSide) $hSide = $h;
            if ($l > $lSide) $lSide = $l;
        }

        $volVert = $lVert * $wVert * $hVert;
        $volHor  = $lHor  * $wHor  * $hHor;
        $volSide = $lSide * $wSide * $hSide;

        if ($volVert <= $volHor && $volVert <= $volSide) {
            return ['length' => $lVert, 'width' => $wVert, 'height' => $hVert];
        }
        if ($volHor <= $volSide) {
            return ['length' => $lHor, 'width' => $wHor, 'height' => $hHor];
        }
        return ['length' => $lSide, 'width' => $wSide, 'height' => $hSide];
    }
}
