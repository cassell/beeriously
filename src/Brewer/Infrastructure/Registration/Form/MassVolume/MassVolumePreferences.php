<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume;

use Beeriously\Universal\ImmutableArray\ImmutableArray;
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

    /**
     * @codeCoverageIgnore
     */
    protected function guardType($item)
    {
        if (!($item instanceof MassVolumePreference)) {
            throw new InvalidArgumentException();
        }
    }
}
