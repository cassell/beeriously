<?php

declare(strict_types=1);

namespace Beeriously\Tests\DataFixtures;

use Beeriously\Brewer\Domain\BrewerId;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\SpecificGravityPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Infrastructure\Doctrine\Fixture;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class TempBrewerFixture extends Fixture
{
    /**
     * @var BrewerId
     */
    private static $brewerId;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $brewer = new \Beeriously\Brewer\Application\Brewer();
        $brewer->setUsername('mrbaseball');
        $brewer->setFirstName('Bob');
        $brewer->setLastName('Uecker');
        $brewer->setPassword('x');
        $brewer->setEmail('support+1dcfaf6b60d3@beeriously.com');

        self::$brewerId = $brewer->getBrewerId();

        $brewery = Brewery::fromBrewer(
            $brewer,
            new UnitedStatesCustomarySystemPreference(),
            new SpecificGravityPreference(),
            new FahrenheitPreference(),
            OccurredOn::now(),
            new BreweryNameFactory($this->getMockTranslator())
        );

        $manager->persist($brewery);
        $manager->flush();
    }

    public static function getBrewerId(): BrewerId
    {
        return self::$brewerId;
    }

    private function getMockTranslator()
    {
        return new class() implements TranslatorInterface {
            public function trans($id, array $parameters = [], $domain = null, $locale = null)
            {
                return 'Bob Uecker\'s Brewery';
            }

            public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
            {
                // TODO: Implement transChoice() method.
            }

            public function setLocale($locale)
            {
                // TODO: Implement setLocale() method.
            }

            public function getLocale()
            {
                // TODO: Implement getLocale() method.
            }
        };
    }
}
