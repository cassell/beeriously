<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\Density;

class DensityPreferenceFactory
{
    /**
     * @var DensityPreferences
     */
    private $preferences;

    public function __construct(DensityPreferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public static function create(): self
    {
        return new self(DensityPreferences::create());
    }

    public function fromCode(string $code): DensityPreference
    {
        foreach ($this->preferences as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }

        throw new \InvalidArgumentException('beeriously.user.preferences.invalid_density');
    }
}
