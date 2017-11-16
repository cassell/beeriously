<?php

namespace Beeriously\Tests\Unit\Domain\Measurements\Weight;

use Beeriously\Domain\Measurements\Weight\Kilograms;
use Beeriously\Domain\Measurements\Weight\Pounds;
use PHPUnit\Framework\TestCase;

class KilogramTest extends TestCase
{
    public function testGetter()
    {
        $this->assertEquals(1.0, (new Kilograms(1.0))->getValue());
    }


}
