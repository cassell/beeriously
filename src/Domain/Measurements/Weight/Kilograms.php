<?php

namespace Beeriously\Domain\Measurements\Weight;

class Kilogram
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromPounds(Pounds $pound)
    {
        return new self( $pound->getValue() / Pounds::POUNDS_PER_KILOGRAM);
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString()
    {
        return number_format($this->getValue(),4) . " kg";
    }

}