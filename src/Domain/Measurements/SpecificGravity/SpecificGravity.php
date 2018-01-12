<?php

declare(strict_types=1);

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
        if ($value < AlcoholByWeight::DENSITY_OF_ETHANOL) {
            throw GravityReadingTooLowException::create($value);
        }

        $this->value = $value;
    }

    public static function fromPlato(Plato $plato): self
    {
        // http://pintwell.com/2011/nov/02/calculate-specific-gravity-plato/
        // ( Plato / ( 258.6 - ( ( Plato / 258.2 ) * 227.1 ) ) + 1 = Specific gravity

        // https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf
        // SG = 1.00001 + 0.0038661 E + 1.3488 x 10^-5 E^2 + 4.3074 x 10^-8 E^3

        return new self(
            1.00001 +
            (0.0038661 * $plato->getValue()) +
            (1.3488 * pow(10, -5) * pow($plato->getValue(), 2)) +
            (4.3074 * pow(10, -8) * pow($plato->getValue(), 3))
        );
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
