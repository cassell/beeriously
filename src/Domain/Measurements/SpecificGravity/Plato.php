<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\SpecificGravity;

class Plato
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        if (abs($value) < 0.003) {
            $value = 0;
        }

        if ($value < -70) {
            throw GravityReadingTooLowException::create($value.' °P');
        }

        $this->value = $value;
    }

    public static function fromSpecificGravityReading(GravityReading $gravityReading)
    {
        //http://www.straighttothepint.com/abv-calculator/
        // P =  (-463.37) + (668.72 × SG) - (205.35 × SG2)
        // P = (-1 * 616.868) + (1111.14 * SG) – (630.272 * SG^2) + (135.997 * SG^3)

        // Reference: Manning, M.P., Understanding Specific Gravity and Extract, Brewing Techniques, 1,3:30-35 (1993)
        // Plato = -676.67 + 1286.4*SG - 800.47*SG*SG + 190.74*SG*SG*SG

        // https://www.homebrewersassociation.org/attachments/0000/2497/Math_in_Mash_SummerZym95.pdf
        // E = –668.962 + 1262.45 SG – 776.43 SG2 + 182.94 SG3

        // http://www.wetnewf.org/pdfs/Brewing_articles/Sugar_Gravity.pdf
        // P  = -616.868 + 1111.14*S - 630.272*S^2 + 135.997*S^3
        // $plato = (-616.868) + (1111.14 * $sg) - (630.272 * pow($sg, 2)) + (135.997 * pow($sg, 3));

        $sg = $gravityReading->getValue();
        $plato = (-668.962) + (1262.45 * $sg) - (776.43 * pow($sg, 2)) + (182.94 * pow($sg, 3));

        return new self(round($plato, 4));
    }

    public function __toString()
    {
        return number_format($this->getValue(), 4).' °P';
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
