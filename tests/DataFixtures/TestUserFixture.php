<?php

declare(strict_types=1);

namespace Beeriously\Tests\DataFixtures;

use Beeriously\Brewer\BrewerId;
use Beeriously\Infrastructure\Doctrine\Fixture;
use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Doctrine\Common\Persistence\ObjectManager;

class TestUserFixture extends Fixture
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
        $brewery = TestBreweryBuilder::createBrewery('Mr. Baseball\'s Brewery', 'Bob', 'Uecker');
        $brewer = TestBreweryBuilder::getOwner($brewery);
        $brewer->setUsername('mrbaseball');
        $brewer->setPlainPassword('frontrow');
        $brewer->setEmail('justabitoutside@mrbaseball.beeriously');

        self::$brewerId = $brewer->getBrewerId();

        $manager->persist($brewery);
        $manager->flush();
    }

    public static function getBrewerId(): BrewerId
    {
        return self::$brewerId;
    }
}
