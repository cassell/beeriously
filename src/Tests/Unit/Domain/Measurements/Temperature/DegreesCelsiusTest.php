<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\Temperature;

use Beeriously\Domain\Measurements\Temperature\AbsoluteZeroException;
use Beeriously\Domain\Measurements\Temperature\DegreesCelsius;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;
use PHPUnit\Framework\TestCase;

class DegreesCelsiusTest extends TestCase
{
    public function testFromFloat()
    {
        $temp = new DegreesCelsius(0);
        $this->assertSame(0.000, $temp->getValue());

        $temp = new DegreesCelsius(100);
        $this->assertSame(100.000, $temp->getValue());

        $temp = new DegreesCelsius(64.128);
        $this->assertSame(64.128, $temp->getValue());
    }

    public function testInvalidString()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString('212');
    }

    public function testMissingUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString('212°');
    }

    public function testInvalidUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesCelsius::fromString('212 °F');
    }

    public function testBelowAbsoluteZero()
    {
        $this->expectException(AbsoluteZeroException::class);
        DegreesCelsius::fromString('-273.16 °C');
    }

    public function testFromString()
    {
        $temp = DegreesCelsius::fromString('0 °C');
        $this->assertSame(0.000, $temp->getValue());
        $this->assertSame('0 °C', (string) $temp);

        $temp = DegreesCelsius::fromString('20 °C');
        $this->assertSame(20.000, $temp->getValue());
        $this->assertSame('20 °C', (string) $temp);

        $temp = DegreesCelsius::fromString('30.117 °C');
        $this->assertSame(30.117, $temp->getValue());
        $this->assertSame('30.117 °C', (string) $temp);

        $temp = DegreesCelsius::fromString('-15.45 °C');
        $this->assertSame(-15.45, $temp->getValue());
        $this->assertSame('-15.45 °C', (string) $temp);
    }

    public function testPrecision()
    {
        $temp = DegreesCelsius::fromString('30.994500 °C');
        $this->assertSame(30.995, $temp->getValue());
        $this->assertSame('30.995 °C', (string) $temp);
    }

    public function testFromFahrenheit()
    {
        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(212));
        $this->assertSame('100 °C', (string) $temp);

        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(-40));
        $this->assertSame('-40 °C', (string) $temp);

        $temp = DegreesCelsius::fromFahrenheit(new DegreesFahrenheit(0));
        $this->assertSame('-17.778 °C', (string) $temp);
    }
}
