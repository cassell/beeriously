<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer\Preference\Density;

use Beeriously\Brewer\Application\Preference\Density\PlatoPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PlatoPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertSame('plato', (new PlatoPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertSame('beeriously.measurements.density.systems.plato.description', (new PlatoPreference())->getTranslationDescriptionIdentifier());
    }
}
