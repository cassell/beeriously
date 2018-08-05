<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\MassVolume;

use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use PHPUnit\Framework\TestCase;

class MetricSystemPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals('si', (new MetricSystemPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertEquals('beeriously.measurements.mass_volume.systems.si.description', (new MetricSystemPreference())->getTranslationDescriptionIdentifier());
    }
}
