<?php

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDefs;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\Nodes\SVGGenericNodeType;
use SVG\SVG;

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

$originalVector = new \webd\vectors\Vector(
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

$path = vsprintf('M %d %d ', $combinedPoints[0]);
foreach (array_slice($combinedPoints, 1) as $newPoint) {
    $path .= vsprintf('A 1,1 0 0 0 %d,%d ', $newPoint);
}




$combinedLine = new \SVG\Nodes\Shapes\SVGPath($path);
$combinedLine->setStyle('stroke', '#ff0000')
    ->setStyle('fill', 'none');
//$combinedLine->setAttribute('marker-start', 'url(#marker-circle)')
//    ->setAttribute('marker-mid', 'url(#marker-circle)')
//    ->setAttribute('marker-end', 'url(#marker-circle)');
$doc->addChild($combinedLine);



header('Content-Type: image/svg+xml');
echo $image;

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
