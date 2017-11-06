<?php

namespace Beeriously\Domain\Measurements\Temperature;

class DegreesFahrenheit implements Temperature
{
    use TemperatureFromString, TemperatureStringFormat;

    private const SYMBOL = "°F";

    private const FLOAT_PRECISION = 3;

    /**
     * @var float
     */
    private $degreesFahrenheit;

    public function __construct(float $value)
    {
        $this->degreesFahrenheit = round($value, self::FLOAT_PRECISION);

        if ($this->degreesFahrenheit === -0.0) {
            $this->degreesFahrenheit = 0;
        }
    }

    public static function getSymbol(): string
    {
        return self::SYMBOL;
    }


    public static function fromCelsius(DegreesCelsius $degreesCelsius)
    {
        return new self(($degreesCelsius->getValue() * 9 / 5) + 32);

    }

    public function getValue(): float
    {
        return $this->degreesFahrenheit;
    }

}