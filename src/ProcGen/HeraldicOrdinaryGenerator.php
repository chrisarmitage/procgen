<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\SVGNode;

class HeraldicOrdinaryGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

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
            'chief',
            'paly',
            'barry',
            'chequy',
            'bendy',
            'lozengy',
            'chevronny',
            'bordure',
            'orle',
        ];

        $method = $methods[mt_rand(0, count($methods) - 1)];
        $method = !empty($params['ordinary']) ? $params['ordinary'] : $method;

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
    public function pale()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -2, -8],
                    [  2, -8],
                    [  2,  8],
                    [ -2,  8],
                ]
            )
        );

        return $polygon;
    }

    /**
     * @return SVGNode
     */
    public function fess()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -2],
                    [  6, -2],
                    [  6,  2],
                    [ -6,  2],
                ]
            )
        );

        return $polygon;
    }

    /**
     * @return SVGNode
     */
    public function saltire()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -8],
                    [  0, -2],
                    [  6, -8],
                    [  8, -6],
                    [  2,  0],
                    [  8,  6],
                    [  6,  8],
                    [  0,  2],
                    [ -6,  8],
                    [ -8,  6],
                    [ -2,  0],
                    [ -8, -6],
                    [ -6, -8],
                ]
            )
        );

        return $polygon;
    }

    /**
     * @return SVGNode
     */
    public function chief()
    {
        $polygon = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -6],
                    [  6, -6],
                    [  6, -2],
                    [ -6, -2],
                ]
            )
        );

        return $polygon;
    }

    /**
     * @return SVGNode[]
     */
    public function paly()
    {
        $polygons = [];
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -4, -8],
                    [ -2, -8],
                    [ -2,  8],
                    [ -4,  8],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  0, -8],
                    [  2, -8],
                    [  2,  8],
                    [  0,  8],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [  4, -8],
                    [  6, -8],
                    [  6,  8],
                    [  4,  8],
                ]
            )
        );

        return $polygons;
    }

    /**
     * @return SVGNode[]
     */
    public function barry()
    {
        $polygons = [];
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -6],
                    [  6, -6],
                    [  6, -4],
                    [ -6, -4],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6, -2],
                    [  6, -2],
                    [  6,  0],
                    [ -6,  0],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6,  2],
                    [  6,  2],
                    [  6,  4],
                    [ -6,  4],
                ]
            )
        );
        $polygons[] = new SVGPolygon(
            $this->generatePoints(
                [
                    [ -6,  6],
                    [  6,  6],
                    [  6,  8],
                    [ -6,  8],
                ]
            )
        );

        return $polygons;
    }


    /**
     * @return SVGNode[]
     */
    public function chequy()
    {
        $polygons = [];

        for ($y = -6; $y <= 8; $y += 4) {

            for ($x = -6; $x <= 6; $x += 4) {

                $polygons[] = new SVGPolygon(
                    $this->generatePoints(
                        [
                            [ $x    , $y],
                            [ $x + 2, $y],
                            [ $x + 2, $y + 2],
                            [ $x    , $y + 2],
                        ]
                    )
                );
                $polygons[] = new SVGPolygon(
                    $this->generatePoints(
                        [
                            [ $x + 2, $y + 2],
                            [ $x + 4, $y + 2],
                            [ $x + 4, $y + 4],
                            [ $x + 2, $y + 4],
                        ]
                    )
                );
            }
        }

        return $polygons;
    }


    /**
     * @return SVGNode[]
     */
    public function bendy()
    {
        $polygons = [];

        for ($y = -14; $y <= 12; $y += 8) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints(
                    [
                        [ -6, $y],
                        [  8, $y + 14],
                        [  6, $y + 16],
                        [ -8, $y + 2],
                    ]
                )
            );
        }

        return $polygons;
    }

    /**
     * @return SVGNode[]
     */
    public function lozengy()
    {
        $polygons = [];

        for ($y = -9; $y <= 12; $y += 3) {
            for ($x = -6; $x <= 6; $x += 3) {
                $polygons[] = new SVGPolygon(
                    $this->generatePoints(
                        [
                            [ $x, $y],
                            [ $x + 1.5, $y + 1.5],
                            [ $x, $y + 3],
                            [ $x - 1.5, $y + 1.5],
                        ]
                    )
                );
            }
        }

        return $polygons;
    }

    /**
     * @return SVGNode[]
     */
    public function chevronny()
    {
        $polygons = [];

        for ($y = -14; $y <= 10; $y += 8) {
            $polygons[] = new SVGPolygon(
                $this->generatePoints(
                    [
                        [  0, $y],
                        [  8, $y + 8],
                        [  6, $y + 10],
                        [  0, $y + 4],
                        [ -6, $y + 10],
                        [ -8, $y + 8],
                    ]
                )
            );
        }

        return $polygons;
    }

    /**
     * @return
     */
    public function bordure()
    {

        $unit = $this->unitSize * 0.75;
        $center = $this->size / 2;

        $path = sprintf('M %d %d', $center + ($unit * -5), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -2))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * 0), $center +  ($unit * 8))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * -6), $center +  ($unit * -2))
            . sprintf( ' L %d %d', $center + ($unit * -6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * -5), $center +  ($unit * -6))
        ;
        $outline = new SVGPath($path);

        return $outline;
    }

    /**
     * @return
     */
    public function orle()
    {

        $unit = $this->unitSize * 0.75;
        $center = $this->size / 2;

        $path = sprintf('M %d %d', $center + ($unit * -5), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -2))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * 0), $center +  ($unit * 8))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * -6), $center +  ($unit * -2))
            . sprintf( ' L %d %d', $center + ($unit * -6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * -5), $center +  ($unit * -6))
        ;
        $outline = new SVGPath($path);
        $outline->setStyle('fill', 'none')
            ->setStyle('stroke-width', ($this->unitSize * 0.75) . 'px');

        return $outline;
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
