<?php

namespace Beeriously\Tests\Unit\Domain\Measurements\Weight;

use Beeriously\Domain\Measurements\Weight\Kilogram;
use Beeriously\Domain\Measurements\Weight\Pound;
use PHPUnit\Framework\TestCase;

class KilogramTest extends TestCase
{
    public function testGetter()
    {
        $this->assertEquals(1.0, (new Kilogram(1.0))->getValue());
    }

    public function testToString()
    {
        $this->assertEquals("1.0000 kg", (string)new Kilogram(1.0));
    }

    public function testFromPounds()
    {
        $this->assertEquals("2.2046 kg",(string) Kilogram::fromPounds(new Pound(1)));
    }

}
