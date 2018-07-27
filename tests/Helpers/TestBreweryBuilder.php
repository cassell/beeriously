<?php

declare(strict_types=1);

namespace Beeriously\Tests\Helpers;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\Roles;
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
        $brewer->addRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

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

    public static function getOwner(Brewery $brewery): Brewer
    {
        foreach ($brewery->getBrewers() as $brewer) {
            if ($brewer->hasRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT)) {
                return $brewer;
            }
        }
    }
}
