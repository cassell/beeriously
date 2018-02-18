<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\Temperature;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class TemperaturePreferences extends ImmutableArray
{
    public function __construct(FahrenheitPreference $f, CelsiusPreference $c)
    {
        parent::__construct([$f, $c]);
    }

    public function fromCode(string $code): TemperatureMeasurementPreference
    {
        foreach ($this as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }
        throw new \InvalidArgumentException('beeriously.user.preferences.invalid_temperature');
    }

    protected function guardType($item)
    {
        if (!($item instanceof TemperatureMeasurementPreference)) {
            throw new InvalidArgumentException();
        }
    }
}
