<?php

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDefs;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\Nodes\SVGGenericNodeType;
use SVG\SVG;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);

$size = 600;

$image = new SVG($size, $size);
$doc = $image->getDocument();

drawGrid($doc, $size);

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


$mode = 'wave';

switch ($mode) {
    case 'wave':
        $points = [
            [ 10, 80 ],
            [ 40, 10 ],
            [ 65, 10 ],
            [ 95, 80 ],

            [ 150, 150 ],
            [ 180, 80 ],

            [ 240, 10 ],
            [ 270, 80 ],

            [ 330, 150 ],
            [ 360, 80 ],
        ];
        $drawGuides = true;
        break;
    case 'hand-drawn':
        $points = [];
        $x = 0;
        $step = 100;
        while ($x <= 600) {
            $points[] = [ $x, 80 + mt_rand(-2, 2) ];
            $points[] = [ $x + $step, 80 + mt_rand(-2, 2) ];
            $x += ($step * 2);
        }
        $drawGuides = false;
        break;
}

renderPath($doc, $points, $drawGuides);



header('Content-Type: image/svg+xml');
echo $image;

function renderPath(SVGDocumentFragment $doc, $points, $drawGuides = false) {
    $sPaths = (count($points) - 4) / 2;
    $path = 'M %d %d C %d %d, %d %d, %d %d'
        . str_repeat(' S %d %d, %d %d', $sPaths);

    $curve = new \SVG\Nodes\Shapes\SVGPath(
        vsprintf(
            $path,
            array_flatten($points)
        )
    );
    $curve->setStyle('fill', 'none')
        ->setStyle('stroke', 'black');

    $doc->addChild($curve);

    if ($drawGuides) {
        $firstGuideLine = new SVGLine(
            $points[0][0],
            $points[0][1],
            $points[1][0],
            $points[1][1]
        );
        $firstGuideLine->setStyle('stroke', 'red')
            ->setAttribute('marker-start', 'url(#marker-circle)')
            ->setAttribute('marker-end', 'url(#marker-circle)');
        $doc->addChild($firstGuideLine);

        array_shift($points);
        array_shift($points);

        while ($points) {
            $guideLine = new SVGLine(
                $points[0][0],
                $points[0][1],
                $points[1][0],
                $points[1][1]
            );
            $guideLine->setStyle('stroke', 'red')
                ->setAttribute('marker-start', 'url(#marker-circle)')
                ->setAttribute('marker-end', 'url(#marker-circle)');
            $doc->addChild($guideLine);

            $impliedGuideLine = new SVGLine(
                $points[1][0],
                $points[1][1],
                $points[1][0] + ($points[1][0] - $points[0][0]),
                $points[1][1] + ($points[1][1] - $points[0][1])
            );
            $impliedGuideLine->setStyle('stroke', 'blue')
                ->setAttribute('marker-start', 'url(#marker-circle)')
                ->setAttribute('marker-end', 'url(#marker-circle)');
            $doc->addChild($impliedGuideLine);

            array_shift($points);
            array_shift($points);
        }
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

function array_flatten($array) {
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}
