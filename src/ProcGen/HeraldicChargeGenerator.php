<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\SVGNode;

class HeraldicChargeGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

    /**
     * @return SVGNode
     */
    public function random($params, $ordinaryType)
    {
        $chargeDefinitions = [
            'lozengeDefinition',
            'malteseCrossDefinition',
        ];
        $chargeDefinitionName = $chargeDefinitions[mt_rand(0, count($chargeDefinitions) - 1)];
        $chargeDefinition = $this->{$chargeDefinitionName}();
        
        $layouts = [
            'blank' => [
                'single',
                'tripleY',
                'fiveY',
                'sixY',
            ],
            'chevron' => [
                'chevronY',
            ],
            'bend' => [
                'twoBend'
            ],
            'fess' => [
                'fessY',
                'invertFessHorizontal',
            ],
        ];
        $layout = $layouts[$ordinaryType][mt_rand(0, count($layouts[$ordinaryType]) - 1)];
        $layout = !empty($params['layout']) ? $params['layout'] : $layout;

        return $this->{$layout}($chargeDefinition, $params);
    }

    protected function lozengeDefinition()
    {
        return [
            [ -3,  0],
            [  0, -4],
            [  3,  0],
            [  0,  4],
        ];
    }

    protected function malteseCrossDefinition()
    {
        return [
            [  0,  0],

            [ -2, -4],
            [  0, -3],
            [  2, -4],
            [  0,  0],

            [  4, -2],
            [  3,  0],
            [  4,  2],
            [  0,  0],

            [  2,  4],
            [  0,  3],
            [ -2,  4],
            [  0,  0],

            [ -4,  2],
            [ -3,  0],
            [ -4, -2],
            [  0,  0],
        ];
    }

    public function single($chargeDefinition, $params)
    {
        $polygons = [];

        $polygons[] = (new SVGPolygon(
            $this->generatePoints($this->transformCharge($chargeDefinition, 0, 0, 1))
        ))->setAttribute('name', 'charge');


        return $polygons;
    }

    public function tripleY($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [  0,  3],
            [ -2.5, -2],
            [  2.5, -2],
        ];
        foreach ($points as $point) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.5))
            );
        }

        return $polygons;
    }

    public function fiveY($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [  0,  4],
            [ -2.5,  0.5],
            [ -2.5, -3],
            [  2.5,  0.5],
            [  2.5, -3],
        ];
        foreach ($points as $point) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
        }

        return $polygons;
    }

    public function sixY($chargeDefinition, $params)
    {
        $polygons = [];

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
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
        }

        return $polygons;
    }

    public function chevronY($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [  0,  4.5],
            [ -3, -3],
            [  3, -3],
        ];
        foreach ($points as $point) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
        }

        return $polygons;
    }


    public function twoBend($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [ -2.5,  2.5],
            [  2.5, -2.5],
        ];
        foreach ($points as $point) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
        }

        return $polygons;
    }

    public function fessY($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [  0,  4.5],
            [ -3, -4],
            [  3, -4],
        ];
        foreach ($points as $point) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
        }

        return $polygons;
    }

    public function invertFessHorizontal($chargeDefinition, $params)
    {
        $polygons = [];

        $points = [
            [  0,  0],
            [ -3,  0],
            [  3,  0],
        ];
        foreach ($points as $point) {
            $polygon = new SVGPolygon(
                $this->generatePoints($this->transformCharge($chargeDefinition, $point[0], $point[1], 0.3))
            );
            $polygon->setAttribute('x-invert', 'true');

            $polygons[] = $polygon;
        }

        return $polygons;
    }


    protected function transformCharge($chargeDefinition, $x, $y, $s)
    {
        $transformed = [];
        foreach ($chargeDefinition as $point) {
            $transformed[] = [($point[0] * $s) + $x, ( $point[1] * $s) + $y];
        }

        return $transformed;
    }

    /**
     * @return SVGNode[]
     */
    public function mascle()
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
                $polygons[] = (new SVGPolygon(
                    $this->generatePoints($this->generateLozenge(0, 0, 1))
                ))->setStyle('fill', 'none')
                    ->setStyle('stroke-width', ($this->unitSize * 0.75) . 'px');
                break;
            case '3':
                $points = [
                    [  0,  3],
                    [ -2.5, -2],
                    [  2.5, -2],
                ];
                foreach ($points as $point) {
                    $polygons[] = (new SVGPolygon(
                        $this->generatePoints($this->generateLozenge($point[0], $point[1], 0.5))
                    ))->setStyle('fill', 'none')
                        ->setStyle('stroke-width', ($this->unitSize * 0.75 * 0.5) . 'px');
                }
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
                    $polygons[] = (new SVGPolygon(
                        $this->generatePoints($this->generateLozenge($point[0], $point[1], 0.3))
                    ))->setStyle('fill', 'none')
                        ->setStyle('stroke-width', ($this->unitSize * 0.75 * 0.3) . 'px');
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
                    $polygons[] = (new SVGPolygon(
                        $this->generatePoints($this->generateLozenge($point[0], $point[1], 0.3))
                    ))->setStyle('fill', 'none')
                        ->setStyle('stroke-width', ($this->unitSize * 0.75 * 0.3) . 'px');
                }
                break;
        }

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
