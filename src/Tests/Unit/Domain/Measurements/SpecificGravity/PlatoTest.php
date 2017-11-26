<?php
declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\SpecificGravity;

use Beeriously\Domain\Measurements\SpecificGravity\GravityReading;
use Beeriously\Domain\Measurements\SpecificGravity\GravityReadingTooLowException;
use Beeriously\Domain\Measurements\SpecificGravity\Plato;
use PHPUnit\Framework\TestCase;

class PlatoTest extends TestCase
{
    public function testLessThanZero()
    {
        $this->expectException(GravityReadingTooLowException::class);
        new Plato(-1);
    }

    public function testGetValue()
    {
        $plato = new Plato(17);
        $this->assertEquals(17,$plato->getValue());
    }

    public function testFromSpecificGravity()
    {
        $gravities = [
            "1.000" => "0.0000 °P",
            "1.019" => "4.8308 °P",
            "1.041" => "10.2348 °P",
            "1.075" => "18.1981 °P"
        ];

        foreach($gravities as $key => $value) {
            $this->assertEquals($value,(string) Plato::fromSpecificGravityReading(new GravityReading((float)$key)));
        }
    }

}
