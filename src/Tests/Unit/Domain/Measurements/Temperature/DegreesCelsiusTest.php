<?php

namespace Beeriously\Tests\Unit\Domain\Measurements\Temperature;

use Beeriously\Domain\Measurements\Temperature\DegreesCelsius;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;
use PHPUnit\Framework\TestCase;

class DegreesCelsiusTest extends TestCase
{
    public function testFromFloat()
    {
        $temp = new DegreesCelsius(0);
        $this->assertEquals(0.000, $temp->getValue());

        $temp = new DegreesCelsius(100);
        $this->assertEquals(100.000, $temp->getValue());

        $temp = new DegreesCelsius(64.128);
        $this->assertEquals(64.128, $temp->getValue());

    }

    public function testInvalidString()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString("212");
    }

    public function testMissingUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString("212°");
    }

    public function testInvalidUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString("212 °F");
    }

    public function testFromString()
    {
        $temp = DegreesCelsius::fromString("0 °C");
        $this->assertEquals(0.000, $temp->getValue());
        $this->assertEquals("0 °C", (string) $temp);

        $temp = DegreesCelsius::fromString("20 °C");
        $this->assertEquals(20.000, $temp->getValue());
        $this->assertEquals("20 °C", (string) $temp);

        $temp = DegreesCelsius::fromString("30.117 °C");
        $this->assertEquals(30.117, $temp->getValue());
        $this->assertEquals("30.117 °C", (string) $temp);

        $temp = DegreesCelsius::fromString("-15.45 °C");
        $this->assertEquals(-15.45, $temp->getValue());
        $this->assertEquals("-15.45 °C", (string) $temp);
    }

    public function testPrecision()
    {
        $temp = DegreesCelsius::fromString("30.994500 °C");
        $this->assertEquals(30.995, $temp->getValue());
        $this->assertEquals("30.995 °C", (string) $temp);
    }

    public function testFromFahrenheit()
    {
        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(212));
        $this->assertEquals("100 °C", (string) $temp);

        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(-40));
        $this->assertEquals("-40 °C", (string) $temp);

        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(0));
        $this->assertEquals("-17.778 °C", (string) $temp);

    }




}
