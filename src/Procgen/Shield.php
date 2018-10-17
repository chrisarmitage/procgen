<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDocumentFragment;

abstract class Shield
{
    protected function drawGrid(SVGDocumentFragment $doc)
    {
        $size = 128;
        $unitSize = 8 * 2;
        for ($y = 0; $y <= $size; $y += $unitSize) {
            $line = new SVGLine($y, 0, $y, $size);
            $line->setStyle('stroke', '#cccccc');
            $doc->addChild($line);
        }
        for ($x = 0; $x <= $size; $x += $unitSize) {
            $line = new SVGLine(0, $x, $size, $x);
            $line->setStyle('stroke', '#cccccc');
            $doc->addChild($line);
        }
    }
}
