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

    public function readOriginalGravity(GravityReading $gravityReading, DegreesFahrenheit $temperatureOfWort): OriginalGravity
    {
        return new OriginalGravity(
            $this->correctGravityForTemperature($gravityReading, $temperatureOfWort)
        );
    }

    public function readFinalGravity(GravityReading $gravityReading, DegreesFahrenheit $temperatureOfWort): FinalGravity
    {
        return new FinalGravity(
            $this->correctGravityForTemperature($gravityReading, $temperatureOfWort)
        );
    }

    /**
     * @param GravityReading $gravityReading
     * @param DegreesFahrenheit $temperatureOfWort
     * @return float
     */
    private function correctGravityForTemperature(GravityReading $gravityReading, DegreesFahrenheit $temperatureOfWort): float
    {
        // http://www.straighttothepint.com/hydrometer-temperature-correction/
        // http://www.musther.net/vinocalc.html
        // https://homebrew.stackexchange.com/questions/4137/temperature-correction-for-specific-gravity
        // https://web.archive.org/web/20110926185142/http://www.primetab.com:80/formulas.html

        // CG = MG * ((1.00130346 – 0.000134722124 * TR + 0.00000204052596 * TR – 0.00000000232820948 * TR) / (1.00130346 – 0.000134722124 * TC + 0.00000204052596 * TC – 0.00000000232820948 * TC));

        return $gravityReading->getValue() * ((1.00130346 - 0.000134722124 * $temperatureOfWort->getValue() + 0.00000204052596 * pow($temperatureOfWort->getValue(), 2) - 0.00000000232820948 * pow($temperatureOfWort->getValue(), 3)) / (1.00130346 - 0.000134722124 * $this->calibrationTemperature->getValue() + 0.00000204052596 * pow($this->calibrationTemperature->getValue(), 2) - 0.00000000232820948 * pow($this->calibrationTemperature->getValue(), 3)));
    }

}