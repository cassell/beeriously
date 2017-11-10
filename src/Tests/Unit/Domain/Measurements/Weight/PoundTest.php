<?php

namespace Beeriously\Tests\Unit\Domain\Measurements\Weight;

use Beeriously\Domain\Measurements\Weight\Kilogram;
use Beeriously\Domain\Measurements\Weight\Pound;
use PHPUnit\Framework\TestCase;

class PoundTest extends TestCase
{
    public function testFromKilos()
    {
        $this->assertEquals(0.9979,round(Pound::fromKilograms(new Kilogram(2.2))->getValue(),4));
    }

    public function testToString()
    {
        $this->assertEquals("1.0000 lbs",(string)new Pound(1));
    }

}
