<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPolygon;

class HeraldicPartyGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

    protected $params;

    /**
     * HeraldicOrdinaryGenerator constructor.
     * @param int $size
     * @param int $unitSize
     * @param     $params
     */
    public function __construct(int $size, int $unitSize, $params)
    {
        $this->size = $size;
        $this->unitSize = $unitSize;
        $this->params = $params;
    }

    /**
     * @return SVGNode
     */
    public function random($params)
    {
        $methods = [
            'bend',
            'cross',
            'pale',
            'fess',
            'saltire',
            'chevron',
            'gyronny',
        ];

        $method = $methods[mt_rand(0, count($methods) - 1)];
        $method = !empty($params['party']) ? $params['party'] : $method;

        return $this->{$method}();
    }

    protected function bend()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -6],
                    [  6, -6],
                    [  6,  6],
                ]
            )
        );

        return $polygon;
    }

    protected function cross()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [  0, -6],
                    [ -6, -6],
                    [ -6,  0],
                    [  0,  0],
                    [  6,  0],
                    [  6,  8],
                    [  0,  8],
                ]
            )
        );

        return $polygon;
    }

    protected function pale()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -6],
                    [  0, -6],
                    [  0,  8],
                    [ -6,  8],
                ]
            )
        );

        return $polygon;
    }

    protected function fess()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -6],
                    [  6, -6],
                    [  6,  0],
                    [ -6,  0],
                ]
            )
        );

        return $polygon;
    }

    protected function saltire()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [ -6, -6],
                    [  6, -6],
                    [  0,  0],
                    [ -8,  8],
                    [  8,  8],
                ]
            )
        );

        return $polygon;
    }

    protected function chevron()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [ -8,  8],
                    [  8,  8],
                ]
            )
        );

        return $polygon;
    }

    protected function gyronny()
    {
        $polygons = [];
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [  0, -8],
                    [  8, -8],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [  8,  0],
                    [  8,  8],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [  0,  8],
                    [ -8,  8],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0,  0],
                    [ -8,  0],
                    [ -8, -8],
                ]
            )
        );

        return $polygons;
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
