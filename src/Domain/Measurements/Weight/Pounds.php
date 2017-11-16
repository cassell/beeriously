<?php

namespace Beeriously\Domain\Measurements\Weight;

class Pounds
{
    const POUNDS_PER_KILOGRAM = 0.45359237;

    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        if($value === -0) {
            $value = 0;
        }

        if($value < 0) {
            throw new \InvalidArgumentException("Weight may not be negative");
        }

        $this->value = $value;
    }

    public function reduceBy(Pounds $pounds): Pounds
    {
        return new self($this->value - $pounds->getValue());
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
       return number_format($this->getValue(),4) . " lbs";
    }

    public static function fromKilograms(Kilogram $kilogram): Pounds
    {
        return new self(self::POUNDS_PER_KILOGRAM * $kilogram->getValue());
    }

}