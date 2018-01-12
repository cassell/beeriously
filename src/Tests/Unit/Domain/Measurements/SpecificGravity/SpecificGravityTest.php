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
    }
}
