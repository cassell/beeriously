<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\MassVolume;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

final class MassVolumePreferences extends ImmutableArray
{
    public function __construct(UnitedStatesCustomarySystemPreference $us,
                                MetricSystemPreference $si)
    {
        parent::__construct([$us, $si]);
    }

    public static function create(): self
    {
        return new self(
            new UnitedStatesCustomarySystemPreference(),
            new MetricSystemPreference()
        );
    }

    protected function guardType($item)
    {
        if (!($item instanceof MassVolumePreference)) {
            throw new InvalidArgumentException();
        }
    }
}
