<?php

namespace Beeriously\Domain\Measurements\Weight;

class Pound
{
    const POUNDS_PER_KILOGRAM = 0.45359237;
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromKilograms(Kilogram $kilogram)
    {
        return new self(self::POUNDS_PER_KILOGRAM * $kilogram->getValue());
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
       return number_format($this->getValue(),4) . " lbs";
    }


}