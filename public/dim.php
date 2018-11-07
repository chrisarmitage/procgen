<?php


use SVG\SVG;

require_once __DIR__ . '/../vendor/autoload.php';

$image = new SVG(200, 200);
$doc = $image->getDocument();

$points = [
    [ 20, 100],
    [180, 100],
];
$points = [
    [ 20, 20],
    [180, 180],
];

$nodes = makeTwinPair($points);

foreach ($nodes as $node) {
    $doc->addChild($node);
}


function makeLine($points) {
    $line = new \SVG\Nodes\Shapes\SVGPolyline($points);

    return $line;
}

function makePlain($points) {
    $line = makeLine($points);
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '40');

    return [$line];
}

function makePair($points) {
    $lines = [];

    $line = makeLine(shiftLine($points, -90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '20');
    $lines[] = $line;

    $line = makeLine(shiftLine($points, 90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '20');
    $lines[] = $line;

    return $lines;
}

function makeTwinPair($points) {
    $lines = [];

    $line = makeLine(shiftLine($points, -90, 30));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '6');
    $lines[] = $line;

    $line = makeLine(shiftLine($points, -90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '6');
    $lines[] = $line;

    $line = makeLine(shiftLine($points, 90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '6');
    $lines[] = $line;

    $line = makeLine(shiftLine($points, 90, 30));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '6');
    $lines[] = $line;

    return $lines;
}

function shiftLine($points, $angle, $distance) {
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

$marker = makeLine($points);
$marker->setStyle('stroke', '#CC0000');
$doc->addChild($marker);

header('Content-Type: image/svg+xml');
echo $image;
