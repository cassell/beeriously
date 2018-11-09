<?php

declare(strict_types=1);

namespace Beeriously\Tests\Helpers;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Brewery\Domain\BreweryId;
use Beeriously\Brewery\Domain\BreweryName;
use Ramsey\Uuid\Uuid;

class TestBreweryBuilder
{
    const TEST_PASSWORD = 'H.R.1337';

    public static function createBrewery(string $breweryName = 'Test Brewery',
                                         string $brewerFirstName = 'First',
                                         string $brewerLastName = 'Last'): Brewery
    {
        $brewer = new Brewer();
        $brewer->setUsername(self::getUsername($brewerFirstName, $brewerLastName));
        $brewer->setFirstName($brewerFirstName);
        $brewer->setLastName($brewerLastName);
        $brewer->setPlainPassword(self::TEST_PASSWORD);
        $brewer->setEmail(self::generateTestEmail($brewer->getUsername(), $breweryName));
        $brewer->setEmailCanonical($brewer->getEmail());
        $brewer->setEnabled(true);
        $brewer->addRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

        $brewery = new Brewery(
            BreweryId::newId(),
            new BreweryName($breweryName),
            $brewer,
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference()
        );

        $brewer->associateWithBrewery($brewery);

        return $brewery;
    }

    public static function getOwner(Brewery $brewery): Brewer
    {
        foreach ($brewery->getBrewers() as $brewer) {
            if ($brewer->hasRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT)) {
                return $brewer;
            }
        }

        throw new \RuntimeException();
    }

    private static function generateTestEmail(string $username, string  $breweryName): string
    {
        $email = $username.'@'.$breweryName.'.beeriously';
        $email = str_replace(' ', '', $email);
        $email = str_replace('-', '-', $email);
        $email = mb_strtolower($email);

        return $email;
    }

    /**
     * @param string $brewerFirstName
     * @param string $brewerLastName
     *
     * @throws \Exception
     *
     * @return string
     */
    private static function getUsername(string $brewerFirstName, string $brewerLastName): string
    {
        $username = $brewerFirstName.'.'.$brewerLastName.'.'.Uuid::uuid4()->toString();
        $username = str_replace(' ', '', $username);
        $username = str_replace('-', '-', $username);
        $username = mb_strtolower($username);

        return $username;
    }
}
