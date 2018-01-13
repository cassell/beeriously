<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\SpecificGravity;

use Beeriously\Domain\Measurements\SpecificGravity\GravityReadingTooLowException;
use Beeriously\Domain\Measurements\SpecificGravity\Plato;
use Beeriously\Domain\Measurements\SpecificGravity\SpecificGravity;
use PHPUnit\Framework\TestCase;

class SpecificGravityTest extends TestCase
{
    public function testLessThanZero()
    {
        $this->expectException(GravityReadingTooLowException::class);
        new SpecificGravity(-1);
    }

    public function testZero()
    {
        $this->expectException(GravityReadingTooLowException::class);
        new SpecificGravity(0);
    }

    public function testLessThanPureEthanol()
    {
        $this->expectException(GravityReadingTooLowException::class);
        new SpecificGravity(0.788);
    }

    public function testFromPlato()
    {
        $gravities = [
            '0.0000' => '1',
            '0.5139' => '1.002',
            '2.0508' => '1.008',
            '4.8269' => '1.019',
            '10.2228' => '1.041',
            '18.1756' => '1.075',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round(SpecificGravity::fromPlato(new Plato((float) $key))->getValue(), 3));
        }

        $gravities = [
            '0.0000' => '1',
            '1' => '1.004',
            '2' => '1.008',
            '3' => '1.012',
            '4' => '1.016',
            '5' => '1.02',
            '6' => '1.024',
            '7' => '1.028',
            '8' => '1.032',
            '9' => '1.036',
            '10' => '1.04',
            '11' => '1.044',
            '12' => '1.048',
            '13' => '1.053',
            '14' => '1.057',
            '15' => '1.061',
            '16' => '1.065',
            '17' => '1.07',
            '18' => '1.074',
            '19' => '1.079',
            '20' => '1.083',
            '21' => '1.088',
            '22' => '1.092',
            '23' => '1.097',
            '24' => '1.101',
            '25' => '1.106',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round(SpecificGravity::fromPlato(new Plato((float) $key))->getValue(), 3));
        }

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round(SpecificGravity::fromPlato(new Plato((float) $key))->getValue(), 3));
        }
    }
}
