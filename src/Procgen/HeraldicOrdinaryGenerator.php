<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\SVGNode;

class HeraldicOrdinaryGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

    /**
     * @return SVGNode
     */
    public function random()
    {
        $methods = [
            'bend',
            'cross',
            'chevron',
        ];

        $method = $methods[mt_rand(0, count($methods) - 1)];

        return $this->{$method}();
    }

    /**
     * @return SVGNode
     */
    public function bend()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
            [
                [ -6, -8],
                [  8,  6],
                [  6,  8],
                [ -8, -6],
            ])
        );

        return $polygon;
    }

    /**
     * @return SVGNode
     */
    public function cross()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -2, -8],
                    [  2, -8],
                    [  2, -2],
                    [  6, -2],
                    [  6,  2],
                    [  2,  2],
                    [  2, 14],
                    [ -2, 14],
                    [ -2,  2],
                    [ -6,  2],
                    [ -6, -2],
                    [ -2, -2],
                    [ -2, -8],
                ]
            )
        );

        return $polygon;
    }

    /**
     * @return SVGNode
     */
    public function chevron()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ 0, -2],
                    [ 8,  6],
                    [ 6,  8],
                    [ 0,  2],
                    [-6,  8],
                    [-8,  6],
                    [ 0, -2],
                ]
            )
        );

        return $polygon;
    }

    protected function generatePoints($points)
    {
        $renderedPoints = [];
        $center = $this->size / 2;

        foreach ($points as $point) {
            $renderedPoints[] =
                [ $center + ($this->unitSize * $point[0]), $center + ($this->unitSize * $point[1])]
            ;
        }

        return $renderedPoints;
    }
}
