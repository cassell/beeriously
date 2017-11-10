<?php

namespace Beeriously\Domain\Measurements\SpecificGravity;

class Plato
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        if($value < 0) {
            throw new GravityReadingTooLowException;
        }

        $this->value = $value;
    }

    public static function fromSpecificGravityReading(GravityReading $gravityReading)
    {
        //http://www.straighttothepint.com/abv-calculator/

        // 2nd Order Polynomial
        // P =  (-463.37) + (668.72 × SG) - (205.35 × SG2)

        // 3rd Order Polynomial
        // P = (-1 * 616.868) + (1111.14 * SG) – (630.272 * SG^2) + (135.997 * SG^3)

        // Reference: Manning, M.P., Understanding Specific Gravity and Extract, Brewing Techniques, 1,3:30-35 (1993)
        // Plato = -676.67 + 1286.4*SG - 800.47*SG*SG + 190.74*SG*SG*SG

        $sg = $gravityReading->getValue();
        $plato = (-616.868) + (1111.14 * $sg) - (630.272 * pow($sg,2)) + (135.997 * pow($sg,3));
        if($plato < 0.004) {
            $plato = 0;
        }

        return new self(round($plato,4));

    }

    public function __toString()
    {
        return number_format($this->getValue(),4) .  " °P";
    }

    public function getValue(): float
    {
        return $this->value;
    }

}