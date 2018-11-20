<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewery\BreweryName;
use Beeriously\Brewery\Event\BreweryNameWasChanged;
use Beeriously\Brewery\Exception\BreweryNameDidNotChangeException;
use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Beeriously\Universal\Time\OccurredOn;
use PHPUnit\Framework\TestCase;

class BreweryChangeNameTest extends TestCase
{
    public function testChangeNameFails()
    {
        $this->expectException(BreweryNameDidNotChangeException::class);
        $brewery = TestBreweryBuilder::createBrewery('Same Name');
        $firstBrewer = $brewery->getBrewers()[0];
        $brewery->changeName(
            new BreweryName('Same Name'),
            $firstBrewer,
            OccurredOn::now()
        );
    }

    public function testChangeName()
    {
        $brewery = TestBreweryBuilder::createBrewery('Parallel World Brewing');

        $this->assertCount(1, $brewery->getBrewers());
        $this->assertCount(0, $brewery->getHistory());

        $firstBrewer = $brewery->getBrewers()[0];

        $brewery->changeName(
            new BreweryName('Silver Branch Brewing Company'),
            $firstBrewer,
            OccurredOn::now()
        );

        $this->assertCount(1, $brewery->getHistory());
        $this->assertInstanceOf(BreweryNameWasChanged::class, $brewery->getHistory()->toArray()[0]);
    }
}
