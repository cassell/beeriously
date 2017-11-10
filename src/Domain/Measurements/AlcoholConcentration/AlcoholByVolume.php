<?php

namespace Beeriously\Domain\Measurements\AlcoholConcentration;

use Beeriously\Domain\Measurements\SpecificGravity\GravityRange;

class AlcoholByVolume
{
    private $value;

    public function __construct(float $value)
    {
        if($value < 0 || $value > 100) {
            throw new \InvalidArgumentException;
        }
        $this->value = $value;
    }

    public static function fromGravityRange(GravityRange $range)
    {
        // http://www.straighttothepint.com/abv-calculator/
        // ABV =(76.08 * (og-fg) / (1.775-og)) * (fg / 0.794)
        return new AlcoholByVolume(
            (76.08 * ($range->getOriginalGravity()->getValue() - $range->getFinalGravity()->getValue()) / (1.775 - $range->getOriginalGravity()->getValue())) * ($range->getFinalGravity()->getValue() / 0.794)
        );
    }

    public function getValue(): float
    {
        return $this->value;
    }

}