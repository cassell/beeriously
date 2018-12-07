<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\MassVolume;

class MassVolumePreferenceFactory
{
    /**
     * @var MassVolumePreferences
     */
    private $preferences;

    public function __construct(MassVolumePreferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public static function create(): self
    {
        return new self(MassVolumePreferences::create());
    }

    public function fromCode(string $code): MassVolumePreference
    {
        foreach ($this->preferences as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }

        throw new \InvalidArgumentException('beeriously.user.preferences.invalid_mass_volume');
    }
}
