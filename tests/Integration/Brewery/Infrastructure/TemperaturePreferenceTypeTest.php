<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery\Infrastructure;

use Beeriously\Brewery\Application\Preference\Density\SpecificGravityPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Application\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Infrastructure\Type\TemperaturePreferenceType;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;

class TemperaturePreferenceTypeTest extends ContainerAwareTestCase
{
    public function testFactory()
    {
        $this->assertInstanceOf(TemperaturePreferenceType::class, $this->getType());
    }

    public function testGetSQLDeclaration()
    {
        $this->assertEquals('VARCHAR(1)', $this->getType()->getSQLDeclaration([], $this->getPlatform()));
    }

    public function testGetDefaultLength()
    {
        $this->assertEquals(1, $this->getType()->getDefaultLength($this->getPlatform()));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->getType()->requiresSQLCommentHint($this->getPlatform()));
    }

    public function testGetName()
    {
        $this->assertEquals('beeriously_brewery_temperature_units_preference', $this->getType()->getName());
    }

    public function testConvertToPHPValue()
    {
        $this->assertInstanceOf(CelsiusPreference::class, $this->getType()->convertToPHPValue('c', $this->getPlatform()));
    }

    public function testConvertToDatabaseValue()
    {
        $this->assertEquals('c', $this->getType()->convertToDatabaseValue(new CelsiusPreference(), $this->getPlatform()));
        $this->assertEquals('f', $this->getType()->convertToDatabaseValue(new FahrenheitPreference(), $this->getPlatform()));
    }

    public function testConvertNullToDatabaseValue()
    {
        $this->assertNull($this->getType()->convertToDatabaseValue(null, $this->getPlatform()));
    }

    public function testConvertThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->getType()->convertToDatabaseValue(new SpecificGravityPreference(), $this->getPlatform());
    }

    private function getType(): TemperaturePreferenceType
    {
        /** @var TemperaturePreferenceType $type */
        $type = Type::getType('beeriously_brewery_temperature_units_preference');

        return $type;
    }

    private function getPlatform(): PostgreSqlPlatform
    {
        return new PostgreSqlPlatform();
    }
}
