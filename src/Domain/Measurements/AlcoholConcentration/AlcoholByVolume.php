<?php

namespace Beeriously\Domain\Measurements\AlcoholConcentration;

use Beeriously\Domain\Measurements\SpecificGravity\GravityRange;

class AlcoholByVolume
{
    private $value;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 100) {
            throw new \InvalidArgumentException();
        }
        $this->value = $value;
    }

    public static function fromGravityRange(GravityRange $range)
    {
        // https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf
        // A%v = A%w (FG / 0.794)

        $aw = (float) AlcoholByWeight::fromGravityRange($range)->getValue();
        $fg = (float) $range->getFinalGravity()->getValue();

        $av = $aw * $fg / AlcoholByWeight::DENSITY_OF_ETHANOL;

        return new self($av);
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
