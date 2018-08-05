<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewery\Domain\BreweryId;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BreweryIdTest extends TestCase
{
    public function test__toString()
    {
        $this->assertEquals('AAA', (string) BreweryId::fromString('AAA'));
    }
}
