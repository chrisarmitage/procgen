<?php

ini_set('display_errors', 'on');

use SVG\SVG;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/vector-lib.php';

$image = new SVG(500, 800);
$doc = $image->getDocument();

//$points = [
//    [ 20, 100],
//    [180, 100],
//];
//$points = [
//    [ 20, 20],
//    [180, 180],
//];
$points = [
    [ 40, 40],
    [ 160, 40],
    [ 160, 100],
    [ 260, 100],
    [ 260, 160],
    [ 200, 220],
    [ 100, 220],
    [  50, 210],
    [ 100, 160],
    [  10, 160],
];
//$points = [
//    [ 40, 40],
//    [ 160, 40],
//    [ 260, 140],
//];

$textLines = [];

$nodes = makeMiterPair($points, $textLines);

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

function makeMiterPair($points, &$textLines) {
    $lines = [];
    $rightPoints = [];
    $leftPoints = [];

    $initRightPoint = shiftLine($points, +90, 20);
    $rightPoints[] = $initRightPoint[0];
    $initLeftPoint = shiftLine($points, -90, 20);
    $leftPoints[] = $initLeftPoint[0];

    while (count($points) >= 3) {

        $deg = rad2deg(
            atan2(
                $points[1][0] - $points[0][0],
                $points[1][1] - $points[0][1]
            )
        );
        $textLines[] = "** Deg {$deg} for "
            . $points[1][0] . ' '
            . $points[0][0] . ' / '
            . $points[1][1] . ' '
            . $points[0][1] . ' ('
            . ($points[1][0] - $points[0][0]) . ' / ' . ($points[1][1] - $points[0][1]) . ')';

        $v1 = new \webd\vectors\Vector(
            $points[1][0] - $points[0][0],
            $points[1][1] - $points[0][1]
        );
        $v2 = new \webd\vectors\Vector(
            $points[2][0] - $points[1][0],
            $points[2][1] - $points[1][1]);

        $tangent = $v1->normalize()->add($v2->normalize())->normalize();
        $textLines[] = 'Tangent: ' . $tangent->getValue()[0] . ' / ' . $tangent->getValue()[1];

        $mitre = new \webd\vectors\Vector(- $tangent->getValue()[1], $tangent->getValue()[0]);

        $textLines[] = "Mitre Vector: " . $mitre->getValue()[0] . ' / ' . $mitre->getValue()[1];

        $normal = (new \webd\vectors\Vector( - $v1->getValue()[1], $v1->getValue()[0]))->normalize();

        $dLength = 20 / $mitre->dotProduct($normal);
        $textLines[] = "d = {$dLength}";
        $textLines[] = "normal = {$normal->getValue()[0]} / {$normal->getValue()[1]}";

        $pin = new \SVG\Nodes\Shapes\SVGCircle(
            $points[1][0] + ($dLength * $mitre->getValue()[0]),
            $points[1][1] + ($dLength * $mitre->getValue()[1]),
            4
        );
        $pin->setStyle('fill', '#00cc00');
        $lines[] = $pin;

        $rightPoints[] = [
            $points[1][0] + ($dLength * $mitre->getValue()[0]),
            $points[1][1] + ($dLength * $mitre->getValue()[1]),
        ];


        $pin = new \SVG\Nodes\Shapes\SVGCircle(
            $points[1][0] - ($dLength * $mitre->getValue()[0]),
            $points[1][1] - ($dLength * $mitre->getValue()[1]),
            4
        );
        $pin->setStyle('fill', '#0000cc');
        $lines[] = $pin;

        $leftPoints[] = [
            $points[1][0] - ($dLength * $mitre->getValue()[0]),
            $points[1][1] - ($dLength * $mitre->getValue()[1]),
        ];

        $line = makeLine(shiftLine($points, -90, 20));
        $line->setStyle('stroke', '#000000')
            ->setStyle('stroke-width', '1');
        //$lines[] = $line;

        $line = makeLine(shiftLine($points, 90, 20));
        $line->setStyle('stroke', '#000000')
            ->setStyle('stroke-width', '1');
        //$lines[] = $line;

        array_shift($points);
    }

    $line = makeLine(shiftLine($points, -90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '1');
    //$lines[] = $line;

    $line = makeLine(shiftLine($points, 90, 20));
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '1');
    //$lines[] = $line;


    $finalRightPoint = shiftLine($points, +90, 20);
    $rightPoints[] = $finalRightPoint[1];
    $finalLeftPoint = shiftLine($points, -90, 20);
    $leftPoints[] = $finalLeftPoint[1];

    $line = makeLine($rightPoints);
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '1')
        ->setStyle('fill', 'none');
    $lines[] = $line;

    $line = makeLine($leftPoints);
    $line->setStyle('stroke', '#000000')
        ->setStyle('stroke-width', '1')
        ->setStyle('fill', 'none');
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
$marker->setStyle('stroke', '#CC0000')
    ->setStyle('fill', 'none');
$doc->addChild($marker);

$textY = 300;
foreach ($textLines as $textLine) {
    $text = new \SVG\Nodes\Texts\SVGText($textLine, 10, $textY);
    $doc->addChild($text);
    $textY += 18;
}

header('Content-Type: image/svg+xml');
echo $image;
