<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\SpecificGravity;

use Beeriously\Domain\Measurements\SpecificGravity\GravityReading;
use Beeriously\Domain\Measurements\SpecificGravity\GravityReadingTooLowException;
use Beeriously\Domain\Measurements\SpecificGravity\Plato;
use PHPUnit\Framework\TestCase;

class PlatoTest extends TestCase
{
    public function testLessThanPureEthanol()
    {
        $this->expectException(GravityReadingTooLowException::class);
        new Plato(-71);
    }

    public function testGetValue()
    {
        $plato = new Plato(17);
        $this->assertSame(17.0, $plato->getValue());
    }

    public function testFromSpecificGravity()
    {
        $gravities = [
            '0.990' => '-2.609',
            '1.000' => '0', // 0.0000 °P
            '1.002' => '0.5139',
            '1.008' => '2.0508',
            '1.019' => '4.8269',
            '1.041' => '10.2228',
            '1.075' => '18.1756',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round(Plato::fromSpecificGravityReading(new GravityReading((float) $key))->getValue(), 4));
        }
    }
}
