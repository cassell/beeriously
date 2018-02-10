<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer;

use Beeriously\Domain\Brewers\Brewer;
use Beeriously\Domain\Brewers\BrewerId;
use Beeriously\Domain\Brewers\FirstName;
use Beeriously\Domain\Brewers\FullName;
use Beeriously\Domain\Brewers\LastName;
use Beeriously\Domain\Brewers\Preference\Density\PlatoPreference;
use Beeriously\Domain\Brewers\Preference\Density\SpecificGravityPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\CelsiusPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\FahrenheitPreference;
use PHPUnit\Framework\TestCase;

class RegisterBrewerTest extends TestCase
{
    public function testGetId()
    {
        $brewer = new Brewer();
        $this->assertNotEmpty($brewer->getId());
        $this->assertInstanceOf(BrewerId::class, $brewer->getBrewerId());
    }

    public function testAlreadyRegistered()
    {
        $this->expectException(\RuntimeException::class);
        $brewer = new Brewer();
        $brewer->addRole(Brewer::ROLE_VALID_BREWER);
        $brewer->completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters(
            new FullName(new FirstName('Test'), new LastName('USBrewer')),
            new UnitedStatesCustomarySystemPreference(),
            new SpecificGravityPreference(),
            new FahrenheitPreference()
        );
    }

    public function testUsSGBrewer()
    {
        $brewer = new Brewer();
        $brewer->completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters(
            new FullName(new FirstName('Test'), new LastName('USBrewer')),
            new UnitedStatesCustomarySystemPreference(),
            new SpecificGravityPreference(),
            new FahrenheitPreference()
        );
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $brewer->getMassVolumePreference());
        $this->assertInstanceOf(SpecificGravityPreference::class, $brewer->getDensityPreference());
        $this->assertInstanceOf(FahrenheitPreference::class, $brewer->getTemperaturePreference());
    }

    public function testUsPlatoBrewer()
    {
        $brewer = new Brewer();
        $brewer->completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters(
            new FullName(new FirstName('Test'), new LastName('USBrewer')),
            new UnitedStatesCustomarySystemPreference(),
            new PlatoPreference(),
            new FahrenheitPreference()
        );
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $brewer->getMassVolumePreference());
        $this->assertInstanceOf(PlatoPreference::class, $brewer->getDensityPreference());
        $this->assertInstanceOf(FahrenheitPreference::class, $brewer->getTemperaturePreference());
    }

    public function testMetricPlatoBrewer()
    {
        $brewer = new Brewer();
        $brewer->completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters(
            new FullName(new FirstName('Test'), new LastName('USBrewer')),
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference()
        );
        $this->assertInstanceOf(MetricSystemPreference::class, $brewer->getMassVolumePreference());
        $this->assertInstanceOf(PlatoPreference::class, $brewer->getDensityPreference());
        $this->assertInstanceOf(CelsiusPreference::class, $brewer->getTemperaturePreference());
    }
}
