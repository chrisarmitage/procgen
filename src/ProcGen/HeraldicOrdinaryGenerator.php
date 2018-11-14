<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Shapes\SVGPolyline;
use SVG\Nodes\SVGNode;

class HeraldicOrdinaryGenerator
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
        $this->params = $params;
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
     * @return SVGNode[]
     */
    public function bend()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $path = [
            [ -8, -8],
            [  8,  8],
        ];

        $ordinaryName = 'bend';
        switch ($type) {
            case 'standard':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'half':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'quarter':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize / 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
            case 'double-cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
        }

        return $polygons;

    }

    /**
     * @return SVGNode
     */
    public function cross()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $strokes = [
            [
                [ -8,  0],
                [  0,  0],
                [  0, -8],
            ],
            [
                [  0, -8],
                [  0,  0],
                [  8,  0],
            ],
            [
                [  8,  0],
                [  0,  0],
                [  0,  8],
            ],
            [
                [  0,  8],
                [  0,  0],
                [ -8,  0],
            ],
        ];

        foreach ($strokes as $path) {


            switch ($type) {
                case 'standard':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'half':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'quarter':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize / 2)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'cotised':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 2, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;

                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 2, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;

                    break;
                case 'double-cotised':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 2, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 3, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;

                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 2, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;
                    //
                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 3, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;

                    break;
            }
        }

        return $polygons;
    }

    /**
     * @return SVGNode
     */
    public function pale()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $path = [
            [  0, -8],
            [  0,  8],
        ];

        $ordinaryName = 'bend';
        switch ($type) {
            case 'standard':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'half':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'quarter':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize / 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
            case 'double-cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
        }

        return $polygons;
    }

    /**
     * @return SVGNode
     */
    public function fess()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $path = [
            [ -8,  0],
            [  8,  0],
        ];

        $ordinaryName = 'fess';
        switch ($type) {
            case 'standard':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'half':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'quarter':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', $ordinaryName)
                    ->setStyle('stroke-width', $this->unitSize / 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
            case 'double-cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
        }

        return $polygons;
    }

    /**
     * @return SVGNode
     */
    public function saltire()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $strokes = [
            [
                [ -8, -8],
                [  0,  0],
                [  8, -8],
            ],
            [
                [  8, -8],
                [  0,  0],
                [  8,  8],
            ],
            [
                [  8,  8],
                [  0,  0],
                [ -8,  8],
            ],
            [
                [ -8,  8],
                [  0,  0],
                [ -8, -8],
            ],
        ];

        foreach ($strokes as $path) {


            switch ($type) {
                case 'standard':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'half':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'quarter':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setAttribute('x-ordinary', 'chevron')
                        ->setStyle('stroke-width', $this->unitSize / 2)
                        ->setStyle('fill', 'none');

                    $polygons[] = $polygon;
                    break;
                case 'cotised':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 2, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;

                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 2, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;

                    break;
                case 'double-cotised':
                    $polygon = new SVGPolyline(
                        $this->generatePoints($path)
                    );
                    $polygon->setStyle('stroke-width', $this->unitSize * 2)
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 2, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;


                    $polygon = new SVGPolyline(
                        $this->generatePoints(
                            $this->shiftLine('left', 3, $path)
                        )
                    );
                    $polygon->setStyle('stroke-width', '5')
                        ->setStyle('fill', 'none');
                    $polygons[] = $polygon;

                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 2, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;
                    //
                    //                $polygon = new SVGPolyline(
                    //                    $this->generatePoints(
                    //                        $this->shiftLine('right', 3, $path)
                    //                    )
                    //                );
                    //                $polygon->setStyle('stroke-width', '5')
                    //                    ->setStyle('fill', 'none');
                    //                $polygons[] = $polygon;

                    break;
            }
        }

        return $polygons;
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
     * @return SVGNode[]
     */
    public function chevron()
    {
        $polygons = [];

        $types = [
            'standard',
            'half',
            'quarter',
            'cotised',
            'double-cotised',
        ];

        $type = $types[mt_rand(0, count($types) - 1)];
        $type = !empty($this->params['variation']) ? $this->params['variation'] : $type;

        $path = [
            [ -8,  8],
            [  0,  0],
            [  8,  8],
        ];

        switch ($type) {
            case 'standard':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', 'chevron')
                    ->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'half':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', 'chevron')
                    ->setStyle('stroke-width', $this->unitSize)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'quarter':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setAttribute('x-ordinary', 'chevron')
                    ->setStyle('stroke-width', $this->unitSize / 2)
                    ->setStyle('fill', 'none');

                $polygons[] = $polygon;
                break;
            case 'cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
            case 'double-cotised':
                $polygon = new SVGPolyline(
                    $this->generatePoints($path)
                );
                $polygon->setStyle('stroke-width', $this->unitSize * 2)
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;


                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('left', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 2, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                $polygon = new SVGPolyline(
                    $this->generatePoints(
                        $this->shiftLine('right', 3, $path)
                    )
                );
                $polygon->setStyle('stroke-width', '5')
                    ->setStyle('fill', 'none');
                $polygons[] = $polygon;

                break;
        }

        return $polygons;
    }

    protected function shiftLine($direction, $distance, $points)
    {
        $angle = ($direction === 'left' ? -90 : 90);
        $newPath = [];

        $newPath[] = $this->generateOffsetPoints(array_slice($points, 0, 2), $angle, $distance)[0];

        if (count($points) > 2) {
            $newPath[] = $this->generateMitrePoints($points, $angle, $distance);
        }

        $newPath[] = $this->generateOffsetPoints(array_slice($points, -2, 2), $angle, $distance)[1];

        return $newPath;
    }

    protected function generateOffsetPoints($points, $angle, $distance) {
        $vectorAngle = rad2deg(
            atan2(
                $points[1][1] - $points[0][1],
                $points[1][0] - $points[0][0]
            )
        );

        $offsetAngle = deg2rad($vectorAngle + $angle);

        $newPoints = [
            [
                $points[0][0] + ($distance * (cos($offsetAngle))),
                $points[0][1] + ($distance * (sin($offsetAngle))),
            ],
            [
                $points[1][0] + ($distance * (cos($offsetAngle))),
                $points[1][1] + ($distance * (sin($offsetAngle))),
            ],
        ];

        return $newPoints;
    }

    protected function generateMitrePoints($points, $angle, $distance)
    {
        $v1 = new \webd\vectors\Vector(
            $points[1][0] - $points[0][0],
            $points[1][1] - $points[0][1]
        );
        $v2 = new \webd\vectors\Vector(
            $points[2][0] - $points[1][0],
            $points[2][1] - $points[1][1]
        );

        $tangent = $v1->normalize()->add($v2->normalize())->normalize();

        $mitre = new \webd\vectors\Vector(- $tangent->getValue()[1], $tangent->getValue()[0]);

        $normal = (new \webd\vectors\Vector( - $v1->getValue()[1], $v1->getValue()[0]))->normalize();

        $dLength = $distance / $mitre->dotProduct($normal);

        if ($angle < 0) {
            $p = [
                $points[1][0] - ($dLength * $mitre->getValue()[0]),
                $points[1][1] - ($dLength * $mitre->getValue()[1]),
            ];
        } else {
            $p = [
                $points[1][0] + ($dLength * $mitre->getValue()[0]),
                $points[1][1] + ($dLength * $mitre->getValue()[1]),
            ];

        }
        return $p;
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
