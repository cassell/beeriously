<?php

declare(strict_types=1);

namespace Beeriously\Tests\Helpers;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Brewery\Domain\BreweryId;
use Beeriously\Brewery\Domain\BreweryName;

class TestBreweryBuilder
{
    public static function createBrewery(string $breweryName = 'Test Brewery',
                                         string $brewerFirstName = 'First',
                                         string $brewerLastName = 'Last'): Brewery
    {
        $brewer = new Brewer();
        $brewer->setFirstName($brewerFirstName);
        $brewer->setLastName($brewerLastName);

        $brewery = new Brewery(
            BreweryId::newId(),
            new BreweryName($breweryName),
            $brewer,
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference()
        );

        return $brewery;
    }
}
