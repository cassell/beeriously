<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery\Infrastructure;

use Beeriously\Brewery\Application\Preference\Density\SpecificGravityPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Infrastructure\Type\DensityPreferenceType;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;

class DensityPreferenceTypeTest extends ContainerAwareTestCase
{
    public function testFactory()
    {
        $this->assertInstanceOf(DensityPreferenceType::class, $this->getType());
    }

    public function testGetSQLDeclaration()
    {
        $this->assertSame('VARCHAR(5)', $this->getType()->getSQLDeclaration([], $this->getPlatform()));
    }

    public function testGetDefaultLength()
    {
        $this->assertSame(5, $this->getType()->getDefaultLength($this->getPlatform()));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->getType()->requiresSQLCommentHint($this->getPlatform()));
    }

    public function testGetName()
    {
        $this->assertSame('beeriously_brewery_density_units_preference', $this->getType()->getName());
    }

    public function testConvertToPHPValue()
    {
        $this->assertInstanceOf(SpecificGravityPreference::class, $this->getType()->convertToPHPValue('sg', $this->getPlatform()));
    }

    public function testConvertToDatabaseValue()
    {
        $this->assertSame('sg', $this->getType()->convertToDatabaseValue(new SpecificGravityPreference(), $this->getPlatform()));
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

    private function getType(): DensityPreferenceType
    {
        /** @var DensityPreferenceType $type */
        $type = Type::getType('beeriously_brewery_density_units_preference');

        return $type;
    }

    private function getPlatform(): PostgreSqlPlatform
    {
        return new PostgreSqlPlatform();
    }
}
