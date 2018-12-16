<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\MassVolume;

use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\UnitedStatesCustomarySystemPreference;
use PHPUnit\Framework\TestCase;

class UnitedStatesCustomarySystemPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals('us', (new UnitedStatesCustomarySystemPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertEquals('beeriously.measurements.mass_volume.systems.us.description', (new UnitedStatesCustomarySystemPreference())->getTranslationDescriptionIdentifier());
    }
}
