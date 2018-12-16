<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Settings;

use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Preference\Density\DensityPreference;
use Beeriously\Brewery\Preference\Density\DensityPreferenceFactory;
use Beeriously\Brewery\Preference\Preference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreferenceFactory;

class BreweryMeasurementSettings
{
    /**
     * @var array
     */
    private $settings;

    private function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public static function setup(TemperaturePreference $temperaturePreference,
                                 DensityPreference $densityPreference,
                                 MassVolumePreference $massVolumePreference
    ): self {
        $settings = new self([]);
        $settings->setTemperature($temperaturePreference);
        $settings->setDensity($densityPreference);
        $settings->setMassVolume($massVolumePreference);

        return $settings;
    }

    /**
     * @internal
     */
    public static function rehydrate(array $settings): self
    {
        return new self($settings);
    }

    public function getDensity(): DensityPreference
    {
        return DensityPreferenceFactory::create()->fromCode($this->get('density'));
    }

    public function setDensity(DensityPreference $densityPreference): void
    {
        $this->set('density', $densityPreference);
    }

    public function getTemperature(): TemperaturePreference
    {
        return TemperaturePreferenceFactory::create()->fromCode($this->get('temperature'));
    }

    public function setTemperature(TemperaturePreference $temperaturePreference): void
    {
        $this->set('temperature', $temperaturePreference);
    }

    public function toArray(): array
    {
        return $this->settings;
    }

    private function get(string $key)
    {
        return $this->settings[$key];
    }

    private function set(string $key, Preference $preference)
    {
        $this->settings[$key] = $preference->getCode();
    }

    public function setMassVolume(MassVolumePreference $massVolumePreference)
    {
        $this->set('temp-mass', $massVolumePreference);
//        $this->setOutputVolume($massVolumePreference->getOutputBeerVolume());
//        $this->setStarterVolume($massVolumePreference->getStarterBeerVolume());
//        $this->setWeight($massVolumePreference->getWeight());
//        $this->setHopsWeight($massVolumePreference->getHopsWeight());
//        $this->setSaltsWeight($massVolumePreference->getSaltsWeight());
//        $this->setPressure($massVolumePreference->getPressure());
    }
}
