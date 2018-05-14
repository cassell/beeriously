<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer\Preference\Temperature;

use Beeriously\Brewer\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewer\Application\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewer\Application\Preference\Temperature\TemperaturePreferences;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TemperaturePreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(FahrenheitPreference::class, $prefs[0]);
        $this->assertInstanceOf(CelsiusPreference::class, $prefs[1]);
        $this->assertSame(2, count($prefs));
    }

    public function testFromCode()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(FahrenheitPreference::class, $prefs->fromCode('f'));
        $this->assertInstanceOf(\Beeriously\Brewer\Application\Preference\Temperature\CelsiusPreference::class, $prefs->fromCode('c'));
    }

    /**
     * @return TemperaturePreferences
     */
    private function build(): TemperaturePreferences
    {
        return new TemperaturePreferences(new FahrenheitPreference(), new \Beeriously\Brewer\Application\Preference\Temperature\CelsiusPreference());
    }
}
