<?php

namespace ProcGen;

use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Structures\SVGDefs;
use SVG\Nodes\SVGGenericNodeType;
use SVG\SVG;

class HeaterShield extends Shield
{
    public function generate($seed, $params)
    {
        mt_srand($seed);
        $size = 128;
        $unit = $size / 16;
        $center = $size / 2;

        $heraldicOrdinaryGenerator = new HeraldicOrdinaryGenerator();
        $heraldicPartyGenerator = new HeraldicPartyGenerator();
        $heraldicChargeGenerator = new HeraldicChargeGenerator();

        $image = new SVG($size, $size);
        $doc = $image->getDocument();

        // $this->drawGrid($doc);

        // Outline
        $path = sprintf('M %d %d', $center + ($unit * -5), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * 6), $center +  ($unit * -2))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * 0), $center +  ($unit * 8))
            . sprintf( ' A %d %d 0 0 1 %d %d', $unit * 16, $unit * 16, $center + ($unit * -6), $center +  ($unit * -2))
            . sprintf( ' L %d %d', $center + ($unit * -6), $center +  ($unit * -6))
            . sprintf( ' L %d %d', $center + ($unit * -5), $center +  ($unit * -6))
        ;
        $outline = new SVGPath($path);
        $outline->setStyle('stroke', '#434b4d')
            ->setStyle('fill', 'none')
            ->setStyle('stroke-width', '4px');
        //error_log($path);
        //$doc->addChild($outline);
        $clip = new SVGPath($path);

       // $outlineClip

        $defs = new SVGDefs();
        $clipContainer = new SVGGenericNodeType('clipPath');
        $clipContainer->setAttribute('id', 'outline');
        $clipContainer->addChild($clip);
        $defs->addChild($clipContainer);
        $doc->addChild($defs);

        $metals = [
            "#ffdc0a",
            "#f0f0f0"
        ];

        $colours = [
            "#0000ff",
            "#ff0000",
            "#aa00aa",
            "#000000",
            "#009600"
        ];

        $background = $metals[array_rand($metals)];
        $foreground = $colours[array_rand($colours)];

        if (mt_rand(1, 2) === 1) {
            if (empty($params['foreground']) && empty($params['background'])) {
                list($background, $foreground) = [$foreground, $background];
            }
        }

        $foreground = !empty($params['foreground']) ? '#' . $params['foreground'] : $foreground;
        $background = !empty($params['background']) ? '#' . $params['background'] : $background;

        $back = new SVGRect(0, 0, $size, $size);
        $back->setStyle('fill', $background)
            ->setAttribute('clip-path', 'url(#outline)');
        $doc->addChild($back);

        $ordinaryType = null;

        $fieldTypeRoll = mt_rand(1, 100);
        if ($fieldTypeRoll <= 45) {
            $fieldType = 'ordinary';
        } else if ($fieldTypeRoll <= 90) {
            $fieldType = 'party';
        } else {
            $fieldType = 'blank';
        }
        $fieldType = !empty($params['fieldType']) ? $params['fieldType'] : $fieldType;

        if ($fieldType === 'blank') {
            $ordinaryType = 'blank';
        }

        switch ($fieldType) {
            case 'ordinary':
                $ordinary = $heraldicOrdinaryGenerator->random($params);
                if (is_array($ordinary) === false) {
                    $ordinary = [$ordinary];
                }
                foreach ($ordinary as $paths) {
                    $fill = $paths->getStyle('fill');
                    $paths->setStyle(
                        'fill',
                        ($fill ?? $foreground)
                    );
                    if ($paths->getStyle('stroke-width') !== null) {
                        $paths->setStyle('stroke', $foreground);
                    }
                    $paths->setAttribute('clip-path', 'url(#outline)');
                    $doc->addChild($paths);

                    if ($paths->getAttribute('x-ordinary') !== null) {
                        $ordinaryType = $paths->getAttribute('x-ordinary');
                    }
                }
                break;
            case 'party':
                $party = $heraldicPartyGenerator->random($params);
                if (is_array($party) === false) {
                    $party = [$party];
                }
                foreach ($party as $paths) {
                    $fill = $paths->getStyle('fill');
                    $paths->setStyle(
                        'fill',
                        ($fill ?? $foreground)
                    );
                    if ($paths->getStyle('stroke-width') !== null) {
                        $paths->setStyle('stroke', $foreground);
                    }
                    $paths->setAttribute('clip-path', 'url(#outline)');
                    $doc->addChild($paths);
                }
                break;
        }

        $addChargeRoll = mt_rand(1, 100);
        if ($addChargeRoll <= 50) {
            $addCharge = 'true';
        } else {
            $addCharge = 'false';
        }
        $addCharge = !empty($params['addCharge']) ? $params['addCharge'] : $addCharge;

        if ($addCharge === 'true' && $ordinaryType !== null) {
            $party = $heraldicChargeGenerator->random($params, $ordinaryType);
            if (is_array($party) === false) {
                $party = [$party];
            }
            foreach ($party as $paths) {
//                $fill = $paths->getStyle('fill');
//                $paths->setStyle(
//                    'fill',
//                    ($fill ?? $foreground)
//                );
//                if ($paths->getStyle('stroke-width') !== null) {
//                    $paths->setStyle('stroke', $foreground);
//                }

                $paths->setStyle('fill', $foreground);
                if ($paths->getAttribute('x-invert') === 'true') {
                    $paths->setStyle('fill', $background);
                }


                $paths->setAttribute('clip-path', 'url(#outline)');
                $doc->addChild($paths);
            }
        }

        $doc->addChild($outline);

        return $image;
    }
}
