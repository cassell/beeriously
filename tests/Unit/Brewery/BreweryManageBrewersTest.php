<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Beeriously\Universal\Time\OccurredOn;
use PHPUnit\Framework\TestCase;

class BreweryManageBrewersTest extends TestCase
{
    public function testAddRemoveBrewer()
    {
        $brewery = TestBreweryBuilder::createBrewery();

        $this->assertCount(1, $brewery->getBrewers());
        $this->assertCount(0, $brewery->getHistory());

        $newBrewer = new Brewer();
        $newBrewer->setFirstName('FN');
        $newBrewer->setLastName('G');

        $brewery->addBrewer($newBrewer, OccurredOn::now());
        $this->assertCount(1, $brewery->getHistory());

        $this->assertCount(2, $brewery->getBrewers());

        $brewery->removeBrewer($newBrewer, OccurredOn::now());

        $this->assertCount(1, $brewery->getBrewers());
        $this->assertCount(2, $brewery->getHistory());
    }

    public function testAddBrewerTwiceThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('beeriously.brewery.brewer.brewer_already_part_of_brewery_exception_message');

        $brewery = TestBreweryBuilder::createBrewery();

        $newBrewer = new Brewer();
        $newBrewer->setFirstName('FN');
        $newBrewer->setLastName('G');
        $brewery->addBrewer($newBrewer, OccurredOn::now());
        $brewery->addBrewer($newBrewer, OccurredOn::now());
    }

    public function testRemoveBrewerThatIsNotPartOfBreweryThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('beeriously.brewery.brewer.brewer_not_part_of_brewery_exception_message');

        $brewery = TestBreweryBuilder::createBrewery();

        $newBrewer = new Brewer();
        $newBrewer->setFirstName('FN');
        $newBrewer->setLastName('G');
        $brewery->removeBrewer($newBrewer, OccurredOn::now());
    }
}
