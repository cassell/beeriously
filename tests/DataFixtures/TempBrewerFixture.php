<?php

declare(strict_types=1);

namespace Beeriously\Tests\DataFixtures;

use Beeriously\Infrastructure\Doctrine\Fixture;
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
        $brewer = new \Beeriously\Brewer\Application\Brewer();
        $brewer->setUsername('mrbaseball');
        $brewer->setFirstName('Bob');
        $brewer->setLastName('Uecker');
        $brewer->setPassword('catcherinthewry');
        $brewer->setEmail('support+'.self::class.'@beeriously.com');

        self::$brewerId = $brewer->getId();

        $manager->persist($brewer);
        $manager->flush();
    }

    public static function getBrewerId(): \Beeriously\Brewer\Domain\BrewerId
    {
        return \Beeriously\Brewer\Domain\BrewerId::fromString(self::$brewerId);
    }
}
