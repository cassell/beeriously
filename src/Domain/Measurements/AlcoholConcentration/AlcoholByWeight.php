<?php

namespace Beeriously\Domain\Measurements\AlcoholConcentration;

use Beeriously\Domain\Measurements\SpecificGravity\GravityRange;
use Beeriously\Domain\Measurements\SpecificGravity\Plato;

class AlcoholByWeight
{
    // https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf
    const DENSITY_OF_ETHANOL = 0.794;

    private $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException();
        }
        $this->value = $value;
    }

    public static function fromGravityRange(GravityRange $range): self
    {
        // http://www.straighttothepint.com/abv-calculator/
        // ABV =(76.08 * (og-fg) / (1.775-og)) * (fg / 0.794)

        // Simple Extract Equation (https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf):
        // A%w = 76.08 (OG – FG) / 1.775 – OG
        // return new self(
        //    (76.08 * ($range->getOriginalGravity()->getValue() - $range->getFinalGravity()->getValue()))
        //        / (1.775 - $range->getOriginalGravity()->getValue())
        //    );

        // https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf:
        // q = 0.22 + 0.001 * OE  // attenuationCoefficient
        // RE = (q * OE + AE) / (1 + q)
        // A%w = (OE – RE) / 2.0665 – 0.010665 OE

        $oe = Plato::fromSpecificGravityReading($range->getOriginalGravity())->getValue();
        $ae = Plato::fromSpecificGravityReading($range->getFinalGravity())->getValue();
        $q = 0.22 + 0.001 * $oe;
        $re = (($q * $oe) + $ae) / (1 + $q);
        $abw = ($oe - $re) / (2.0665 - (0.010665 * $oe));

        return new self($abw);
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
