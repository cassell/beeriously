<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\Temperature;

class TemperaturePreferenceFactory
{
    /**
     * @var TemperaturePreferences
     */
    private $preferences;

    public function __construct(TemperaturePreferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public static function create(): self
    {
        return new self(TemperaturePreferences::create());
    }

    public function fromCode(string $code): TemperaturePreference
    {
        foreach ($this->preferences as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }

        throw new \InvalidArgumentException('beeriously.user.preferences.invalid_temperature');
    }
}
