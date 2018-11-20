<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGPolygon;
use webd\vectors\Vector;

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

        $variation = $this->params['lineVariation'] ?? 'none';

        switch ($variation) {
            case 'invected':
                $points = $this->generatePoints(
                    [
                        [ -6, -6],
                        [  6,  6],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(5);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 10; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);
                $variatedLine = array_shift($points);

                foreach (array_slice($combinedPoints, 1) as $newPoint) {
                    $path .= vsprintf('A 1,1 0 0 1 %d,%d ', $newPoint);
                }

                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            case 'engrailed':
                $points = $this->generatePoints(
                    [
                        [ -6, -6],
                        [  6,  6],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(5);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 10; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);
                $variatedLine = array_shift($points);

                foreach (array_slice($combinedPoints, 1) as $newPoint) {
                    $path .= vsprintf('A 1,1 0 0 0 %d,%d ', $newPoint);
                }

                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            case 'embattled':
                $points = $this->generatePoints(
                    [
                        [ -6, -6],
                        [  6,  6],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(4);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 4; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);


                /**
                 * Embattled
                 */

                $pLeft = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 1),
                    0,
                    1.5 * $this->unitSize
                );
                $pForwards = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 1),
                    1.5 * $this->unitSize,
                    0
                );
                $pRight = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 1),
                    0,
                    -1.5 * $this->unitSize
                );

                for ($n = 1; $n <= 4; $n++) {
                    $path .= vsprintf(
                        ' l %d %d l %d %d l %d %d l %d %d',
                        [
                            $pForwards->x, $pForwards->y,
                            $pLeft->x, $pLeft->y,
                            $pForwards->x, $pForwards->y,
                            $pRight->x, $pRight->y,
                        ]
                    );
                }

                //$variatedLine = array_shift($points);


                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            default:
                $points = $this->generatePoints(
                    [
                        [ -6, -6],
                        [  6,  6],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                //$variatedLine = array_shift($points);

                $path = vsprintf('M %d %d ', $points[0]);
                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
        }


        //        $polygon = new SVGPolygon(
        //            $this->generatePoints(
        //                [
        //                    [ -6, -6],
        //                    [  6, -6],
        //                    [  6,  0],
        //                    [ -6,  0],
        //                ]
        //            )
        //        );

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

        $variation = $this->params['lineVariation'] ?? 'none';

        switch ($variation) {
            case 'invected':
                $points = $this->generatePoints(
                    [
                        [ -6,  0],
                        [  6,  0],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(5);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 10; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);
                $variatedLine = array_shift($points);

                foreach (array_slice($combinedPoints, 1) as $newPoint) {
                    $path .= vsprintf('A 1,1 0 0 1 %d,%d ', $newPoint);
                }

                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            case 'engrailed':
                $points = $this->generatePoints(
                    [
                        [ -6,  0],
                        [  6,  0],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(5);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 10; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);
                $variatedLine = array_shift($points);

                foreach (array_slice($combinedPoints, 1) as $newPoint) {
                    $path .= vsprintf('A 1,1 0 0 0 %d,%d ', $newPoint);
                }

                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            case 'embattled':
                $points = $this->generatePoints(
                    [
                        [ -6,  0],
                        [  6,  0],
                        [  6,  8],
                        [ -6,  8],
                    ]
                );
                $originalVector = new Vector(
                    $points[1][0] - $points[0][0],
                    $points[1][1] - $points[0][1]
                );
                $splitVectors = $originalVector->div(4);

                $combinedPoints = [
                    $points[0],
                ];

                for ($n = 1; $n <= 4; $n++) {
                    $combinedPoints[] = [
                        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
                        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
                    ];
                }

                $path = vsprintf('M %d %d ', $points[0]);
                $variatedLine = array_shift($points);


                /**
                 * Embattled
                 */

                $pLeft = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 0),
                    0,
                    1.5 * $this->unitSize
                );
                $pForwards = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 0),
                    1.5 * $this->unitSize,
                    0
                );
                $pRight = $this->generateVectorOffsetPoints(
                    new Point(0, 0),
                    new Point(1, 0),
                    0,
                    -1.5 * $this->unitSize
                );

                for ($n = 1; $n <= 4; $n++) {
                    $path .= vsprintf(
                        ' l %d %d l %d %d l %d %d l %d %d',
                        [
                            $pForwards->x, $pForwards->y,
                            $pLeft->x, $pLeft->y,
                            $pForwards->x, $pForwards->y,
                            $pRight->x, $pRight->y,
                        ]
                    );
                }



                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
            default:
                $points = $this->generatePoints(
                    [
                        [ -6,  0],
                        [  6,  0],
                        [  6, -6],
                        [ -6, -6],
                    ]
                );
                //$variatedLine = array_shift($points);

                $path = vsprintf('M %d %d ', $points[0]);
                foreach (array_slice($points, 1) as $linePoints) {
                    $path .= vsprintf('L %d %d ', $linePoints);
                }

                $polygon = new SVGPath($path);
                break;
        }


//        $polygon = new SVGPolygon(
//            $this->generatePoints(
//                [
//                    [ -6, -6],
//                    [  6, -6],
//                    [  6,  0],
//                    [ -6,  0],
//                ]
//            )
//        );

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

    protected function generateVectorOffsetPoints(Point $start, Point $end, $vectorDistance, $offsetDistance) {
        $vectorAngle = rad2deg(
            atan2(
                $end->y - $start->y,
                $end->x - $start->x
            )
        );

        $offsetAngle = deg2rad($vectorAngle + 90);

        $newPoint = new Point(
            $start->x + ($offsetDistance * (cos($offsetAngle))) + ($vectorDistance * (cos(deg2rad($vectorAngle)))),
            $start->y + ($offsetDistance * (sin($offsetAngle))) + ($vectorDistance * (sin(deg2rad($vectorAngle))))
        );
        //var_dump($newPoint);

        return $newPoint;
    }


}

class Point
{
    public $x;
    public $y;

    /**
     * Point constructor.
     * @param $x
     * @param $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
