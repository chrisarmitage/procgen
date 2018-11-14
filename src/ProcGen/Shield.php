<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGDocumentFragment;

abstract class Shield
{
    protected $size;
    protected $unitSize;

    protected function drawGrid(SVGDocumentFragment $doc)
    {

        for ($y = 0; $y <= $this->size; $y += $this->unitSize) {
            $line = new SVGLine($y, 0, $y, $this->size);
            $line->setStyle('stroke', '#cccccc');
            $doc->addChild($line);
        }
        for ($x = 0; $x <= $this->size; $x += $this->unitSize) {
            $line = new SVGLine(0, $x, $this->size, $x);
            $line->setStyle('stroke', '#cccccc');
            $doc->addChild($line);
        }
    }
}
