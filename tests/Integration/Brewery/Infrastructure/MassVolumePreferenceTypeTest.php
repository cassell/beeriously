<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery\Infrastructure;

use Beeriously\Brewery\Application\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Infrastructure\Type\MassVolumePreferenceType;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;

class MassVolumePreferenceTypeTest extends ContainerAwareTestCase
{
    public function testFactory()
    {
        $this->assertInstanceOf(MassVolumePreferenceType::class, $this->getType());
    }

    public function testGetSQLDeclaration()
    {
        $this->assertSame('VARCHAR(2)', $this->getType()->getSQLDeclaration([], $this->getPlatform()));
    }

    public function testGetDefaultLength()
    {
        $this->assertSame(2, $this->getType()->getDefaultLength($this->getPlatform()));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->getType()->requiresSQLCommentHint($this->getPlatform()));
    }

    public function testGetName()
    {
        $this->assertSame('beeriously_brewery_mass_volume_units_preference', $this->getType()->getName());
    }

    public function testConvertToPHPValue()
    {
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $this->getType()->convertToPHPValue('us', $this->getPlatform()));
    }

    public function testConvertToDatabaseValue()
    {
        $this->assertSame('us', $this->getType()->convertToDatabaseValue(new UnitedStatesCustomarySystemPreference(), $this->getPlatform()));
    }

    public function testConvertNullToDatabaseValue()
    {
        $this->assertNull($this->getType()->convertToDatabaseValue(null, $this->getPlatform()));
    }

    public function testConvertThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->getType()->convertToDatabaseValue(new CelsiusPreference(), $this->getPlatform());
    }

    private function getType(): MassVolumePreferenceType
    {
        return Type::getType('beeriously_brewery_mass_volume_units_preference');
    }

    private function getPlatform(): PostgreSqlPlatform
    {
        return new PostgreSqlPlatform();
    }
}
