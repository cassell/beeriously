<?php

namespace Beeriously\Domain\Measurements\Temperature;


class DegreesCelsius implements Temperature
{
    use TemperatureFromString, TemperatureStringFormat;

    private const SYMBOL = "°C";

    private const FLOAT_PRECISION = 3;

    /**
     * @var float
     */
    private $degreesCelsius;

    public function __construct(float $value)
    {
        $this->degreesCelsius = round($value, self::FLOAT_PRECISION);
        if ($this->degreesCelsius === -0.0) {
            $this->degreesCelsius = 0;
        }

        if($this->degreesCelsius < AbsoluteZero::IN_CELSIUS) {
            throw new AbsoluteZeroException;
        }


    }

    public static function getSymbol(): string
    {
        return self::SYMBOL;
    }

    public static function fromFahrenheit(DegreesFahrenheit $fahrenheit): self
    {
        return new self(($fahrenheit->getValue() - 32.0) * 5 / 9);
    }

    public function getValue(): float
    {
        return $this->degreesCelsius;
    }

}