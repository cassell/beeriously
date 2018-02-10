<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer\Preference\MassVolume;

use Beeriously\Domain\Brewers\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use PHPUnit\Framework\TestCase;

class UnitedStatesCustomarySystemPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertSame('us', (new UnitedStatesCustomarySystemPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertSame('beeriously.measurements.mass_volume.systems.us.description', (new UnitedStatesCustomarySystemPreference())->getTranslationDescriptionIdentifier());
    }
}
