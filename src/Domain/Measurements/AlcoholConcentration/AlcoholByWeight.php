<?php

namespace Beeriously\Domain\Measurements\AlcoholConcentration;

class AlcoholByWeight
{
    const DENSITY_OF_ETHANOL = 0.789;

    private $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException;
        }
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

}