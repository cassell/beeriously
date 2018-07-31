<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewer;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Domain\BrewerId;
use Beeriously\Brewer\Domain\FirstName;
use Beeriously\Brewer\Domain\LastName;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BrewerTest extends TestCase
{
    public function testGetBrewerId()
    {
        $brewer = new Brewer();
        $this->assertInstanceOf(BrewerId::class, $brewer->getBrewerId());
    }

    public function testName()
    {
        $brewer = new Brewer();
        $brewer->setFirstName('Mitch');
        $brewer->setLastName('Steele');

        $this->assertSame('Mitch', $brewer->getFirstName());
        $this->assertSame('Steele', $brewer->getLastName());
        $fullName = $brewer->getFullName();

        $this->assertSame('Mitch Steele', (string) $fullName);
        $this->assertSame(new FirstName('Mitch'), $fullName->getFirstName());
        $this->assertSame(new LastName('Steele'), $fullName->getLastName());
        $this->assertSame('{"first":"Mitch","last":"Steele"}', $fullName->serialize());
    }
}
