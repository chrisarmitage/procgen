<?php


namespace ProcGen;


class Vector
{
    /**
     * @var float
     */
    protected $magnitude;

    protected $direction;

    /**
     * Vector constructor.
     * @param $magnitude
     * @param $direction
     */
    protected function __construct($magnitude, $direction)
    {
        $this->magnitude = $magnitude;
        $this->direction = $direction;
    }

    public static function makeFromPolar($magnitude, $angle)
    {
        return new self($magnitude, $angle);
    }

    public static function makeFromCartesian($x, $y)
    {
        return new self(
            sqrt(($x ** 2) + ($y ** 2)),
            rad2deg(atan($y / $x))
        );
    }

    public function getCartesian()
    {
        return [
            'x' => $this->magnitude * cos(deg2rad($this->direction)),
            'y' => $this->magnitude * sin(deg2rad($this->direction)),
        ];
    }

    public function getPolar()
    {
        return [
            'magnitude' => $this->magnitude,
            'direction' => $this->direction,
        ];
    }

    public function add(Vector $other)
    {
        return self::makeFromCartesian(
            $this->getCartesian()['x'] + $other->getCartesian()['x'],
            $this->getCartesian()['y'] + $other->getCartesian()['y']
        );
    }

    public function subtract(Vector $other)
    {
        return self::makeFromCartesian(
            $this->getCartesian()['x'] - $other->getCartesian()['x'],
            $this->getCartesian()['y'] - $other->getCartesian()['y']
        );
    }
}
