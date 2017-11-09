<?php

namespace Beeriously\Domain\Equipment\SpecificGravityReadingDevice;

use Beeriously\Domain\Measurements\SpecificGravity\FinalGravity;
use Beeriously\Domain\Measurements\SpecificGravity\GravityReading;
use Beeriously\Domain\Measurements\SpecificGravity\OriginalGravity;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;

class Hydrometer implements SpecificGravityReadingDevice
{
    /**
     * @var DegreesFahrenheit
     */
    private $calibrationTemperature;

    public function __construct(DegreesFahrenheit $calibrationTemperature, GravityReading $minimumGravity = null, GravityReading $maximumGravityReading = null)
    {
        $this->calibrationTemperature = $calibrationTemperature;
    }

    public function readOriginalGravity(GravityReading $gravityReading, DegreesFahrenheit $temperatureAtReading): OriginalGravity
    {
        // http://www.straighttothepint.com/hydrometer-temperature-correction/
        // CG = MG * ((1.00130346 – 0.000134722124 * TR + 0.00000204052596 * TR – 0.00000000232820948 * TR) / (1.00130346 – 0.000134722124 * TC + 0.00000204052596 * TC – 0.00000000232820948 * TC));
//        return new OriginalGravity(
//            $gravityReading->getValue() * ((1.00130346 - 0.000134722124 * $temperatureAtReading->getValue() + 0.00000204052596 * $temperatureAtReading->getValue() - 0.00000000232820948 * $temperatureAtReading->getValue()) / (1.00130346 - 0.000134722124 * $this->calibrationTemperature->getValue() + 0.00000204052596 * $this->calibrationTemperature->getValue() - 0.00000000232820948 * $this->calibrationTemperature->getValue()))
//        );

        return new OriginalGravity(
            $gravityReading->getValue() * ((1.00130346 - 0.000134722124 * $temperatureAtReading->getValue() + 0.00000204052596 * pow($temperatureAtReading->getValue(), 2) - 0.00000000232820948 * pow($temperatureAtReading->getValue(), 3)) / (1.00130346 - 0.000134722124 * $this->calibrationTemperature->getValue() + 0.00000204052596 * pow($this->calibrationTemperature->getValue(), 2) - 0.00000000232820948 * pow($this->calibrationTemperature->getValue(), 3)))
        );
    }

    public function readFinalGravity(GravityReading $gravityReading, DegreesFahrenheit $temperatureAtReading): FinalGravity
    {

    }

}