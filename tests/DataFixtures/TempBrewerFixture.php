<?php

declare(strict_types=1);

namespace Beeriously\Tests\DataFixtures;

use Beeriously\Application\Doctrine\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TempBrewerFixture extends Fixture
{
    private static $brewerId = '';

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $brewer = new \Beeriously\Application\Brewers\Brewer();
        $brewer->setUsername('mrbaseball');
        $brewer->setFirstName('Bob');
        $brewer->setLastName('Uecker');
        $brewer->setPassword('catcherinthewry');
        $brewer->setEmail('suppor+'.self::class.'@beeriously.com');

        self::$brewerId = $brewer->getId();

        $manager->persist($brewer);
        $manager->flush();
    }

    public static function getBrewerId(): \Beeriously\Domain\Brewers\BrewerId
    {
        return \Beeriously\Domain\Brewers\BrewerId::fromString(self::$brewerId);
    }
}
