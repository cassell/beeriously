<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\Temperature;

trait TemperatureFromString
{
    abstract public function __construct(float $value);

    /**
     * @param string $string
     *
     * @return DegreesCelsius|DegreesFahrenheit
     */
    public static function fromString(string $string)
    {
        if (!preg_match("/(\-*)([\d]*.?[\d]*) ".self::getSymbol().'/', $string, $matches)) {
            throw new \InvalidArgumentException();
        }

        $floatTemp = (float) $matches[2];

        $sign = $matches[1];
        if ('-' === $sign) {
            $floatTemp *= -1;
        }

        return new self($floatTemp);
    }
}
