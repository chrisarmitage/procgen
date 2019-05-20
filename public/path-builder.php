<?php

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDefs;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\Nodes\SVGGenericNodeType;
use SVG\SVG;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);

interface Component {}

class Move implements Component
{
    protected $endX;
    protected $endY;

    public function __construct($endX, $endY)
    {
        $this->endX = $endX;
        $this->endY = $endY;
    }

    public function __toString()
    {
        return "M {$this->endX} {$this->endY}";
    }

    /**
     * @return mixed
     */
    public function getEndX()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * @return mixed
     */
    public function getC2X()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getC2Y()
    {
        return $this->endY;
    }
}

class Line implements Component
{
    protected $endX;
    protected $endY;
    protected $relative;

    public function __construct($endX, $endY, $relative = false)
    {
        $this->endX = $endX;
        $this->endY = $endY;
        $this->relative = $relative;
    }

    public function __toString()
    {
        return ($this->relative ? 'l' : 'L') . " {$this->endX} {$this->endY}";
    }

    /**
     * @return mixed
     */
    public function getEndX()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * @return mixed
     */
    public function getC2X()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getC2Y()
    {
        return $this->endY;
    }
}

class BezierCurve implements Component
{
    protected $endX;
    protected $endY;
    protected $c1X;
    protected $c1Y;
    protected $c2X;
    protected $c2Y;
    protected $relative;

    public function __construct($endX, $endY, $c1X, $c1Y, $c2X, $c2Y, $relative = false)
    {
        $this->endX = $endX;
        $this->endY = $endY;
        $this->c1X = $c1X;
        $this->c1Y = $c1Y;
        $this->c2X = $c2X;
        $this->c2Y = $c2Y;
        $this->relative = $relative;
    }

    public function __toString()
    {
        return ($this->relative ? 'c' : 'C') . " {$this->c1X} {$this->c1Y} {$this->c2X} {$this->c2Y} {$this->endX} {$this->endY}";
    }

    /**
     * @return mixed
     */
    public function getEndX()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * @return mixed
     */
    public function getC1X()
    {
        return $this->c1X;
    }

    /**
     * @return mixed
     */
    public function getC1Y()
    {
        return $this->c1Y;
    }

    /**
     * @return mixed
     */
    public function getC2X()
    {
        return $this->c2X;
    }

    /**
     * @return mixed
     */
    public function getC2Y()
    {
        return $this->c2Y;
    }
}

class ContinuingBezierCurve implements Component
{
    protected $endX;
    protected $endY;
    protected $c2X;
    protected $c2Y;

    public function __construct($endX, $endY, $c2X, $c2Y)
    {
        $this->endX = $endX;
        $this->endY = $endY;
        $this->c2X = $c2X;
        $this->c2Y = $c2Y;
    }

    public function __toString()
    {
        return "S {$this->c2X} {$this->c2Y} {$this->endX} {$this->endY}";
    }

    /**
     * @return mixed
     */
    public function getEndX()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * @return mixed
     */
    public function getC2X()
    {
        return $this->c2X;
    }

    /**
     * @return mixed
     */
    public function getC2Y()
    {
        return $this->c2Y;
    }

}

class QuadraticCurve implements Component
{
    protected $endX;
    protected $endY;
    protected $c2X;
    protected $c2Y;

    public function __construct($endX, $endY, $c2X, $c2Y)
    {
        $this->endX = $endX;
        $this->endY = $endY;
        $this->c2X = $c2X;
        $this->c2Y = $c2Y;
    }

    public function __toString()
    {
        return "Q {$this->c2X} {$this->c2Y} {$this->endX} {$this->endY}";
    }

    /**
     * @return mixed
     */
    public function getEndX()
    {
        return $this->endX;
    }

    /**
     * @return mixed
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * @return mixed
     */
    public function getC2X()
    {
        return $this->c2X;
    }

    /**
     * @return mixed
     */
    public function getC2Y()
    {
        return $this->c2Y;
    }

}

class Path
{
    protected $components = [];

    public function addComponent(Component $component)
    {
        $this->components[] = $component;

        return $this;
    }

    public function getPath()
    {
        $path = '';

        foreach ($this->components as $component) {
            $path .= (string) $component . ' ';
        }

        return $path;
    }

    public function getGuideLines()
    {
        $lines = [];

        $previous = null;

        foreach ($this->components as $component) {

            if ($component instanceof BezierCurve || $component instanceof ContinuingBezierCurve) {
                $guideLine = new SVGLine(
                    $component->getEndX(),
                    $component->getEndY(),
                    $component->getC2X(),
                    $component->getC2Y()
                );
                $guideLine->setStyle('stroke', 'red')
                    ->setAttribute('marker-start', 'url(#marker-circle)')
                    ->setAttribute('marker-end', 'url(#marker-circle)');
                $lines[] = $guideLine;
            }

            if ($component instanceof BezierCurve) {
                $guideLine = new SVGLine(
                    $previous->getEndX(),
                    $previous->getEndY(),
                    $component->getC1X(),
                    $component->getC1Y()
                );
                $guideLine->setStyle('stroke', 'red')
                    ->setAttribute('marker-start', 'url(#marker-circle)')
                    ->setAttribute('marker-end', 'url(#marker-circle)');
                $lines[] = $guideLine;
            }

            if ($component instanceof ContinuingBezierCurve) {
                $guideLine = new SVGLine(
                    $previous->getEndX() + ($previous->getEndX() - $previous->getC2X()),
                    $previous->getEndY() + ($previous->getEndY() - $previous->getC2Y()),
                    $previous->getEndX(),
                    $previous->getEndY()
                );
                $guideLine->setStyle('stroke', 'blue')
                    ->setAttribute('marker-start', 'url(#marker-circle)')
                    ->setAttribute('marker-end', 'url(#marker-circle)');
                $lines[] = $guideLine;
            }

            $previous = $component;
        }

        return $lines;
    }
}


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

/**
 * NEW CODE
 */
$path = new Path();
//$path->addComponent(new Move(10, 280))
//    ->addComponent(new BezierCurve(95, 280, 40, 210, 65, 210))
//    ->addComponent(new ContinuingBezierCurve(180, 280, 150, 350))
//    //->addComponent(new ContinuingBezierCurve(270, 280, 240, 210))
//    ->addComponent(new Line(270, 280))
//    //->addComponent(new ContinuingBezierCurve(360, 280, 330, 350));
//    ->addComponent(new BezierCurve(360, 280, 300, 350, 330, 350));

$path->addComponent(new Move(100, 200))
    ->addComponent(new Line(100, 300))
    ->addComponent(new BezierCurve(80, 320, 100, 320, 100, 320));

$svgPath = new \SVG\Nodes\Shapes\SVGPath($path->getPath());
$svgPath->setStyle('fill', 'none')
    ->setStyle('stroke', 'black');
//$doc->addChild($svgPath);

foreach ($path->getGuideLines() as $guideLine) {
    //$doc->addChild($guideLine);
}

//$path = new Path();
//$path->addComponent(new Move(200, 200))
//    ->addComponent(new Line(200, 230))
//    ->addComponent(new BezierCurve(240, 290, 200, 270, 230, 280))
//    ->addComponent(new ContinuingBezierCurve(240, 320, 260, 320))
//    ->addComponent(new Line(200, 320));
//
//$svgPath = new \SVG\Nodes\Shapes\SVGPath($path->getPath());
//$svgPath->setStyle('fill', 'none')
//    ->setStyle('stroke', 'black');
//$doc->addChild($svgPath);
//
//foreach ($path->getGuideLines() as $guideLine) {
//    $doc->addChild($guideLine);
//}

$path = new Path();
$path->addComponent(new Move(160, 200))
    ->addComponent(new Line(200, 280))
    ->addComponent(new QuadraticCurve(180, 300, 210, 300))
    ->addComponent(new Line(120, 300))
    ->addComponent(new QuadraticCurve(100, 280, 90, 300))
    ->addComponent(new Line(140, 200))
;

$svgPath = new \SVG\Nodes\Shapes\SVGPath($path->getPath());
$svgPath->setStyle('fill', 'none')
    ->setStyle('stroke', 'black');
$doc->addChild($svgPath);

foreach ($path->getGuideLines() as $guideLine) {
    $doc->addChild($guideLine);
}

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

