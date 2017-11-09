<?php

namespace Beeriously\Domain\Measurements\SpecificGravity;

class GravityReading
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        // https://en.wikipedia.org/wiki/Beer_measurement#Strength
        // Water has a SG of 1.000, absolute alcohol has a SG of 0.789
        if($value < 0.789) {
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