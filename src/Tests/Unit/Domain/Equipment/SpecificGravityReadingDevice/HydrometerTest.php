<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Equipment\SpecificGravityReadingDevice;

use Beeriously\Domain\Equipment\SpecificGravityReadingDevice\Hydrometer;
use Beeriously\Domain\Measurements\SpecificGravity\GravityReading;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;
use PHPUnit\Framework\TestCase;

class HydrometerTest extends TestCase
{
    public function testGravityTooLow()
    {
        $this->expectException(\InvalidArgumentException::class);
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60), new GravityReading(0.990), new GravityReading(1.170));
        $hydrometer->readOriginalGravity(new GravityReading(0.8), new DegreesFahrenheit(60));
    }

    public function testGravityTooHigh()
    {
        $this->expectException(\InvalidArgumentException::class);
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60), new GravityReading(0.990), new GravityReading(1.170));
        $hydrometer->readOriginalGravity(new GravityReading(2.0), new DegreesFahrenheit(60));
    }

    public function testNoTemperatureCorrection()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60), new GravityReading(0.990), new GravityReading(1.170));

        $gravities = [
            '1.020' => '1.02',
            '1.030' => '1.03',
            '1.040' => '1.04',
            '1.055' => '1.055',
            '1.061' => '1.061',
            '1.117' => '1.117',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) $hydrometer->readOriginalGravity(new GravityReading((float) $key), new DegreesFahrenheit(60))->getValue());
        }
    }

    public function testHigherCorrections()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60), new GravityReading(0.990), new GravityReading(1.170));
        $warmRoomTemp = new DegreesFahrenheit(80);

        $gravities = [
            '1.020' => '1.022',
            '1.030' => '1.032',
            '1.040' => '1.042',
            '1.055' => '1.057',
            '1.061' => '1.063',
            '1.117' => '1.12',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round($hydrometer->readOriginalGravity(new GravityReading((float) $key), $warmRoomTemp)->getValue(), 3));
        }
    }

    public function testLowerCorrections()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(68), new GravityReading(0.990), new GravityReading(1.170));
        $coldRoomTemp = new DegreesFahrenheit(55);

        $gravities = [
            '1.020' => '1.019',
            '1.030' => '1.029',
            '1.040' => '1.039',
            '1.055' => '1.054',
            '1.061' => '1.06',
            '1.117' => '1.116',
        ];

        foreach ($gravities as $key => $value) {
            $this->assertSame($value, (string) round($hydrometer->readOriginalGravity(new GravityReading((float) $key), $coldRoomTemp)->getValue(), 3));
        }
    }
}
