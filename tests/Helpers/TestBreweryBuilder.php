<?php

declare(strict_types=1);

namespace Beeriously\Tests\Helpers;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MetricSystemPreference;
use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\BreweryId;
use Beeriously\Brewery\BreweryName;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Settings\BreweryMeasurementSettings;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Beeriously\Infrastructure\File\StorageKey;
use Ramsey\Uuid\Uuid;

class TestBreweryBuilder
{
    const TEST_PASSWORD = 'H.R.1337';

    public static function createBrewery(string $breweryName = 'Test Brewery',
                                         string $brewerFirstName = 'First',
                                         string $brewerLastName = 'Last'): Brewery
    {
        $brewer = new Brewer();
        $brewer->setUsername(self::makeUsername($brewerFirstName, $brewerLastName));
        $brewer->setFirstName($brewerFirstName);
        $brewer->setLastName($brewerLastName);
        $brewer->setPlainPassword(self::TEST_PASSWORD);
        $brewer->setEmail(self::generateTestEmail($brewer->getUsername(), $breweryName));
        $brewer->setEmailCanonical($brewer->getEmail());
        $brewer->setEnabled(true);
        $brewer->addRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);
        $brewer->setProfilePhotoKey(new StorageKey(Brewer::DEFAULT_PROFILE_PHOTO_KEY));

        $brewery = new Brewery(
            BreweryId::newId(),
            new BreweryName($breweryName),
            $brewer,
            BreweryMeasurementSettings::setup(
                new CelsiusPreference(),
                new PlatoPreference(),
                new MetricSystemPreference()
            ),
            BrewerySharingSettings::defaultNotSharing(),
            new StorageKey(Brewery::DEFAULT_LOGO_PHOTO_KEY)
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
    private static function makeUsername(string $brewerFirstName, string $brewerLastName): string
    {
        $username = $brewerFirstName.'.'.$brewerLastName.'.'.Uuid::uuid4()->toString();
        $username = str_replace(' ', '', $username);
        $username = str_replace('-', '-', $username);
        $username = mb_strtolower($username);

        return $username;
    }
}
