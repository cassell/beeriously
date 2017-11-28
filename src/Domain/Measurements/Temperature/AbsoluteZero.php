<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\Temperature;

class AbsoluteZero
{
    const IN_CELSIUS = -273.15;
    const IN_FAHRENHEIT = -459.67;

    public static function toCelsius()
    {
        return new DegreesCelsius(self::IN_CELSIUS);
    }

    public static function toFahrenheit()
    {
        return new DegreesFahrenheit(self::IN_FAHRENHEIT);
    }
}
