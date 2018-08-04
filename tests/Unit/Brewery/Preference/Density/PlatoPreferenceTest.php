<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Density;

use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PlatoPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals('plato', (new PlatoPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertEquals('beeriously.measurements.density.systems.plato.description', (new PlatoPreference())->getTranslationDescriptionIdentifier());
    }
}
