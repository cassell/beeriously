<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewery\Preference\Density;

use Beeriously\Brewery\Application\Preference\Density\SpecificGravityPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SpecificGravityPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertSame('sg', (new SpecificGravityPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertSame('beeriously.measurements.density.systems.sg.description', (new SpecificGravityPreference())->getTranslationDescriptionIdentifier());
    }
}
