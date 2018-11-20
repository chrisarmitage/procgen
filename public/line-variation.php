<?php

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDefs;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\Nodes\SVGGenericNodeType;
use SVG\SVG;
use webd\vectors\Vector;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/vector-lib.php';

ini_set('display_errors', 1);

$size = 600;

$image = new SVG($size, $size);
$doc = $image->getDocument();

//drawGrid($doc, $size);


$defs = new SVGDefs();
$markerContainer = new SVGGenericNodeType('marker');
$markerContainer->setAttribute('id', 'marker-circle')
    ->setAttribute('markerWidth', 8)
    ->setAttribute('markerHeight', 8)
    ->setAttribute('refX', 5)
    ->setAttribute('refY', 5);
$marker = new \SVG\Nodes\Shapes\SVGCircle(5, 5, 3);
$marker->setStyle('stroke', 'none')
    ->setStyle('fill', 'red');
$markerContainer->addChild($marker);
$defs->addChild($markerContainer);
$doc->addChild($defs);

$points = [
    [ 10, 30],
    [ 410, 30],
];
$originalLine = new SVGLine(
    $points[0][0],
    $points[0][1],
    $points[1][0],
    $points[1][1]
);
$originalLine->setStyle('stroke', '#00ff00')
    ->setStyle('fill', 'none');
$doc->addChild($originalLine);

$originalVector = new Vector(
    $points[1][0] - $points[0][0],
    $points[1][1] - $points[0][1]
);

$splitVectors = $originalVector->div(10);

$combinedPoints = [
    [ 10, 60],
];


for ($n = 1; $n <= 10; $n++) {
    $combinedPoints[] = [
        $combinedPoints[$n-1][0] + $splitVectors->getValue()[0],
        $combinedPoints[$n-1][1] + $splitVectors->getValue()[1],
    ];
}

/**
 * Engrailed
 */
$path = vsprintf('M %d %d ', $combinedPoints[0]);
foreach (array_slice($combinedPoints, 1) as $newPoint) {
    $path .= vsprintf('A 1,1 0 0 0 %d,%d ', $newPoint);
}

$combinedLine = new \SVG\Nodes\Shapes\SVGPath($path);
$combinedLine->setStyle('stroke', '#ff0000')
    ->setStyle('fill', 'none');
$combinedLine->setAttribute('marker-start', 'url(#marker-circle)')
    ->setAttribute('marker-mid', 'url(#marker-circle)')
    ->setAttribute('marker-end', 'url(#marker-circle)');
$doc->addChild($combinedLine);


/**
 * Zig1
 */
$startingPoints = [
    [ 10, 120]
];

$path = vsprintf('M %d %d ', $startingPoints[0]);
for ($n = 1; $n <= 10; $n++) {
    $path .= ' l 10 -10'
        . ' l 20 20'
        . ' l 10 -10';
}

$combinedLine = new \SVG\Nodes\Shapes\SVGPath($path);
$combinedLine->setStyle('stroke', '#ff0000')
    ->setStyle('fill', 'none');
$combinedLine->setAttribute('marker-start', 'url(#marker-circle)')
    ->setAttribute('marker-mid', 'url(#marker-circle)')
    ->setAttribute('marker-end', 'url(#marker-circle)');
$doc->addChild($combinedLine);



/**
 * Zig2
 */
$startingPoints = [
    [ 10, 180]
];

$stepPoints = [
    [ 0, 0],
    [ 10, 0],
];


for ($yOffset = 0; $yOffset >= 0; $yOffset -= 0.25) {
    $s1 = generateVectorOffsetPoints(
        new Point(0, 0),
        new Point(1, $yOffset),
        10,
        10
    );
    $s2 = generateVectorOffsetPoints(
        new Point(0, 0),
        new Point(1, $yOffset),
        20,
        -20
    );

    $path = vsprintf('M %d %d ', $startingPoints[0]);
    for ($n = 1; $n <= 10; $n++) {
        $path .= vsprintf(
            ' l %d %d l %d %d l %d %d',
            [
                $s1->x, -$s1->y,
                $s2->x, -$s2->y,
                $s1->x, -$s1->y,
            ]
        );
    }

    $combinedLine = new \SVG\Nodes\Shapes\SVGPath($path);
    $combinedLine->setStyle('stroke', '#ff00ff')
        ->setStyle('fill', 'none');
    $combinedLine->setAttribute('marker-start', 'url(#marker-circle)')
        ->setAttribute('marker-mid', 'url(#marker-circle)')
        ->setAttribute('marker-end', 'url(#marker-circle)');
    $doc->addChild($combinedLine);
}


/**
 * Embattled
 */
for ($yOffset = 0; $yOffset >= -1; $yOffset -= 0.25) {
    $pLeft = generateVectorOffsetPoints(
        new Point(0, 0),
        new Point(1, $yOffset),
        0,
        20
    );
    $pForwards = generateVectorOffsetPoints(
        new Point(0, 0),
        new Point(1, $yOffset),
        20,
        0
    );
    $pRight = generateVectorOffsetPoints(
        new Point(0, 0),
        new Point(1, $yOffset),
        0,
        -20
    );

    $path = sprintf('M %d %d ', $startingPoints[0][0], $startingPoints[0][1] + 300);
    for ($n = 1; $n <= 10; $n++) {
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

    $combinedLine = new \SVG\Nodes\Shapes\SVGPath($path);
    $combinedLine->setStyle('stroke', '#ff00ff')
        ->setStyle('fill', 'none');
//    $combinedLine->setAttribute('marker-start', 'url(#marker-circle)')
//        ->setAttribute('marker-mid', 'url(#marker-circle)')
//        ->setAttribute('marker-end', 'url(#marker-circle)');
    $doc->addChild($combinedLine);
}



//die();


header('Content-Type: image/svg+xml');
echo $image;

function generateVectorOffsetPoints(Point $start, Point $end, $vectorDistance, $offsetDistance) {
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



function drawGrid(SVGDocumentFragment $doc, $size)
{
    $major = 50;
    $minor = 10;
    for ($y = 0; $y <= $size; $y += $minor) {
        $line = new SVGLine($y, 0, $y, $size);
        $line->setStyle('stroke', '#cccccc');
        $doc->addChild($line);
    }
    for ($x = 0; $x <= $size; $x += $minor) {
        $line = new SVGLine(0, $x, $size, $x);
        $line->setStyle('stroke', '#cccccc');
        $doc->addChild($line);
    }

    for ($y = 0; $y <= $size; $y += $major) {
        $line = new SVGLine($y, 0, $y, $size);
        $line->setStyle('stroke', '#999999');
        $doc->addChild($line);
    }
    for ($x = 0; $x <= $size; $x += $major) {
        $line = new SVGLine(0, $x, $size, $x);
        $line->setStyle('stroke', '#999999');
        $doc->addChild($line);
    }
}

function generateOffsetPoints($points, $angle, $distance) {
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
