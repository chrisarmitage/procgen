<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\SVGNode;

class HeraldicChargeGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

    /**
     * @return SVGNode
     */
    public function random($params)
    {
        $methods = [
            'lozenge',
        ];

        $method = $methods[mt_rand(0, count($methods) - 1)];
        $method = !empty($params['charge']) ? $params['charge'] : $method;

        return $this->{$method}($params);
    }


    /**
     * @return SVGNode[]
     */
    public function lozenge()
    {
        $number = [
            '1',
            '3',
            '5',
            '6',
        ];
        $count = $number[mt_rand(0, count($number) - 1)];
        $count = !empty($params['chargeCount']) ? $params['chargeCount'] : $count;

        $polygons = [];

        switch ($count) {
            case '1':
                $polygons[] = new SVGPolygon(
                    $this->generatePoints($this->generateLozenge(0, 0, 1))
                );
                break;
            case '3':
                $polygons[] = new SVGPolygon(
                    $this->generatePoints($this->generateLozenge(0, 3, 0.5))
                );
                $polygons[] = new SVGPolygon(
                    $this->generatePoints($this->generateLozenge(-2.5, -2, 0.5))
                );
                $polygons[] = new SVGPolygon(
                    $this->generatePoints($this->generateLozenge(2.5, -2, 0.5))
                );
                break;
            case '5':
                $points = [
                    [  0,  4],
                    [ -2.5,  0.5],
                    [ -2.5, -3],
                    [  2.5,  0.5],
                    [  2.5, -3],
                ];
                foreach ($points as $point) {
                    $polygons[] = new SVGPolygon(
                        $this->generatePoints($this->generateLozenge($point[0], $point[1], 0.3))
                    );
                }
                break;
            case '6':
                $points = [
                    [ -3.0, -3],
                    [  0.0, -3],
                    [  3.0, -3],

                    [ -1.5,  0.5],
                    [  1.5,  0.5],

                    [  0,  4],
                ];
                foreach ($points as $point) {
                    $polygons[] = new SVGPolygon(
                        $this->generatePoints($this->generateLozenge($point[0], $point[1], 0.3))
                    );
                }
                break;
        }

        return $polygons;
    }

    protected function generateLozenge($x, $y, $s)
    {
        return [
            [ (-3 * $s) + $x, ( 0 * $s) + $y],
            [ ( 0 * $s) + $x, (-4 * $s) + $y],
            [ ( 3 * $s) + $x, ( 0 * $s) + $y],
            [ ( 0 * $s) + $x, ( 4 * $s) + $y],
        ];
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