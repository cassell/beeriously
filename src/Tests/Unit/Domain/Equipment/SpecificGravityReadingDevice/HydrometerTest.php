<?php
declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Equipment\SpecificGravityReadingDevice;

use Beeriously\Domain\Equipment\SpecificGravityReadingDevice\Hydrometer;
use Beeriously\Domain\Measurements\SpecificGravity\GravityReading;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;
use PHPUnit\Framework\TestCase;

class HydrometerTest extends TestCase
{
    public function testSameValue()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60));

        $gravities = [
            "1.020" => "1.020",
            "1.030" => "1.030",
            "1.040" => "1.040",
            "1.055" => "1.055",
            "1.061" => "1.061",
            "1.117" => "1.117"
        ];

        foreach($gravities as $key => $value) {
            $this->assertEquals($value,(string) $hydrometer->readOriginalGravity(new GravityReading((float) $key),new DegreesFahrenheit(60)));
        }
    }

    public function testHigherCorrections()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(60));
        $roomTemperatureInFlorida = new DegreesFahrenheit(80);

        $gravities = [
            "1.020" => "1.022",
            "1.030" => "1.032",
            "1.040" => "1.042",
            "1.055" => "1.057",
            "1.061" => "1.063",
            "1.117" => "1.120"
        ];

        foreach($gravities as $key => $value) {
            $this->assertEquals($value,(string) $hydrometer->readOriginalGravity(new GravityReading((float) $key), $roomTemperatureInFlorida));
        }
    }

    public function testLowerCorrections()
    {
        $hydrometer = new Hydrometer(new DegreesFahrenheit(68));
        $ambientMinnesotaHigh = new DegreesFahrenheit(55);

        $gravities = [
            "1.020" => "1.019",
            "1.030" => "1.029",
            "1.040" => "1.039",
            "1.055" => "1.054",
            "1.061" => "1.060",
            "1.117" => "1.116"
        ];

        foreach($gravities as $key => $value) {
            $this->assertEquals($value,(string) $hydrometer->readOriginalGravity(new GravityReading((float) $key), $ambientMinnesotaHigh));
        }
    }


}
