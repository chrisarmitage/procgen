<?php

namespace ProcGen;

use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class HeraldicChargeExternalGenerator
{
    protected $size = 128;
    protected $unitSize = 8;

    /**
     * @return SVGNode
     */
    public function random($params, $ordinaryType) {
        $files = [
            'red-rose',
            'white-rose',
        ];
        $file = $files[mt_rand(0, count($files) - 1)];

        $layouts = [
            'blank' => [
                'single',
                'tripleY',
            ],
            'chevron' => [
                'chevronY',
            ],
            'fess' => [
                'single',
            ],
        ];
        $layout = $layouts[$ordinaryType][mt_rand(0, count($layouts[$ordinaryType]) - 1)];
        $layout = !empty($params['layout']) ? $params['layout'] : $layout;

        return $this->{$layout}($file, $params);
    }

    public function single($file, $params)
    {
        $polygons = [];
        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 2;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', ($this->size - $roseSize) / 2);
        $nestedSvg->setAttribute('y', ($this->size - $roseSize) / 2);
        $polygons[] = $nestedSvg;

        return $polygons;
    }

    public function tripleY($file, $params)
    {
        $polygons = [];


        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', ($this->size - $roseSize) / 2);
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (3 * $this->unitSize));
        $polygons[] = $nestedSvg;



        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', (($this->size - $roseSize) / 2) + (-2.5 * $this->unitSize));
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (-2 * $this->unitSize));
        $polygons[] = $nestedSvg;


        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', (($this->size - $roseSize) / 2) + (2.5 * $this->unitSize));
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (-2 * $this->unitSize));
        $polygons[] = $nestedSvg;

        return $polygons;
    }

    public function chevronY($file, $params)
    {
        $polygons = [];


        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', ($this->size - $roseSize) / 2);
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (4.5 * $this->unitSize));
        $polygons[] = $nestedSvg;



        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', (($this->size - $roseSize) / 2) + (-3 * $this->unitSize));
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (-3 * $this->unitSize));
        $polygons[] = $nestedSvg;


        $svgRose = SVG::fromFile(__DIR__ . '/../../svg/' . $file . '.svg');
        $svgDocument = $svgRose->getDocument();
        $viewBox = $svgDocument->getAttribute('viewBox');
        $rose = $svgDocument->getChild(0);

        $roseSize = 128 / 4;
        $nestedSvg = new SVGDocumentFragment($roseSize, $roseSize);
        $nestedSvg->addChild($rose);
        $nestedSvg->setAttribute('viewBox', $viewBox);
        $nestedSvg->setAttribute('x', (($this->size - $roseSize) / 2) + (3 * $this->unitSize));
        $nestedSvg->setAttribute('y', (($this->size - $roseSize) / 2) + (-3 * $this->unitSize));
        $polygons[] = $nestedSvg;

        return $polygons;
    }
}
