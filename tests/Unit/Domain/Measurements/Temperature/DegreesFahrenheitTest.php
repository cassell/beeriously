<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\Temperature;

use Beeriously\Domain\Measurements\Temperature\DegreesCelsius;
use Beeriously\Domain\Measurements\Temperature\DegreesFahrenheit;
use PHPUnit\Framework\TestCase;

class DegreesFahrenheitTest extends TestCase
{
    public function testFromFloat()
    {
        $temp = new DegreesFahrenheit(0);
        $this->assertSame(0.000, $temp->getValue());

        $temp = new DegreesFahrenheit(-0.000);
        $this->assertSame(0.000, $temp->getValue());

        $temp = new DegreesFahrenheit(451);
        $this->assertSame(451.000, $temp->getValue());

        $temp = new DegreesFahrenheit(64.128);
        $this->assertSame(64.128, $temp->getValue());
    }

    public function testInvalidString()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesFahrenheit::fromString('451');
    }

    public function testMissingUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesFahrenheit::fromString('451°');
    }

    public function testInvalidUnits()
    {
        $this->expectException(\InvalidArgumentException::class);
        DegreesFahrenheit::fromString('451 °C');
    }

    public function testFromString()
    {
        $temp = DegreesFahrenheit::fromString('0 °F');
        $this->assertSame(0.000, $temp->getValue());
        $this->assertSame('0 °F', (string) $temp);

        $temp = DegreesFahrenheit::fromString('-0 °F');
        $this->assertSame(0.000, $temp->getValue());
        $this->assertSame('0 °F', (string) $temp);

        $temp = DegreesFahrenheit::fromString('20 °F');
        $this->assertSame(20.000, $temp->getValue());
        $this->assertSame('20 °F', (string) $temp);

        $temp = DegreesFahrenheit::fromString('30.11655 °F');
        $this->assertSame(30.117, $temp->getValue());
        $this->assertSame('30.117 °F', (string) $temp);
    }

    public function testFromCelsius()
    {
        $temp = DegreesFahrenheit::fromCelsius(new DegreesCelsius(100));
        $this->assertSame('212 °F', (string) $temp);

        $temp = DegreesFahrenheit::fromCelsius(new DegreesCelsius(-40));
        $this->assertSame('-40 °F', (string) $temp);
    }

    public function testFromCelsiusToZeroFahrenheit()
    {
        $temp = DegreesFahrenheit::fromCelsius(new DegreesCelsius(-17.778));
        $this->assertSame('0 °F', (string) $temp);
    }
}
