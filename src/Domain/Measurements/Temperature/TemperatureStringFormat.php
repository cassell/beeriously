<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\Temperature;

trait TemperatureStringFormat
{
    abstract public function getValue(): float;

    abstract protected static function getSymbol(): string;

    public function __toString(): string
    {
        return round($this->getValue(), 3).' '.self::getSymbol();
    }
}
