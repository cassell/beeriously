<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Temperature;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class TemperaturePreferences extends ImmutableArray
{
    public function __construct(FahrenheitPreference $f, CelsiusPreference $c)
    {
        parent::__construct([$f, $c]);
    }

    public static function create(): self
    {
        return new self(
            new FahrenheitPreference(),
            new CelsiusPreference()
        );
    }

    /**
     * @codeCoverageIgnore
     */
    protected function guardType($item)
    {
        if (!($item instanceof TemperaturePreference)) {
            throw new InvalidArgumentException();
        }
    }
}
