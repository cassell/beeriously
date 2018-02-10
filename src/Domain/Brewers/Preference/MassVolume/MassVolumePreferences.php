<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\MassVolume;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class MassVolumePreferences extends ImmutableArray
{
    public function __construct(UnitedStatesCustomarySystemPreference $us, MetricSystemPreference $si)
    {
        parent::__construct([$us, $si]);
    }

    public function fromCode(string $code): MassVolumeMeasurementPreference
    {
        foreach ($this as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }
        throw new \InvalidArgumentException();
    }

    protected function guardType($item)
    {
        if (!($item instanceof MassVolumeMeasurementPreference)) {
            throw new InvalidArgumentException();
        }
    }
}
