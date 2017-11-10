<?php

namespace Beeriously\Domain\Measurements\SpecificGravity;

use Beeriously\Domain\Measurements\AlcoholConcentration\AlcoholByWeight;

class SpecificGravity
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        // https://en.wikipedia.org/wiki/Beer_measurement#Strength
        // Water has a SG of 1.000, absolute alcohol has a SG of 0.789
        if($value < AlcoholByWeight::DENSITY_OF_ETHANOL) {
            throw new GravityReadingTooLowException;
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) round($this->getValue(),3);
    }

    public function getValue()
    {
        return $this->value;
    }

}