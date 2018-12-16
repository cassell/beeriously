<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery\Infrastructure;

use Beeriously\Brewery\Infrastructure\Type\BrewerySharingSettingsType;
use Beeriously\Brewery\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;

class BrewerySharingSettingsTypeTest extends ContainerAwareTestCase
{
    public function testFactory()
    {
        $this->assertInstanceOf(BrewerySharingSettingsType::class, $this->getType());
    }

    public function testGetSQLDeclaration()
    {
        $this->assertEquals('TEXT', $this->getType()->getSQLDeclaration([], $this->getPlatform()));
    }

    public function testGetDefaultLength()
    {
        $this->assertNull($this->getType()->getDefaultLength($this->getPlatform()));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->getType()->requiresSQLCommentHint($this->getPlatform()));
    }

    public function testGetName()
    {
        $this->assertEquals('beeriously_brewery_sharing_settings', $this->getType()->getName());
    }

    public function testConvertToPHPValue()
    {
        $this->assertInstanceOf(BrewerySharingSettings::class, $this->getType()->convertToPHPValue('{"beer_list":false}', $this->getPlatform()));
    }

    public function testConvertToDatabaseValue()
    {
        $this->assertEquals('{"beer_list":false}', $this->getType()->convertToDatabaseValue(BrewerySharingSettings::defaultNotSharing(), $this->getPlatform()));
    }

    public function testNullThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->getType()->convertToDatabaseValue('', $this->getPlatform());
    }

    public function testConvertThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->getType()->convertToDatabaseValue(new CelsiusPreference(), $this->getPlatform());
    }

    private function getType(): BrewerySharingSettingsType
    {
        /** @var BrewerySharingSettingsType $type */
        $type = Type::getType('beeriously_brewery_sharing_settings');

        return $type;
    }

    private function getPlatform(): PostgreSqlPlatform
    {
        return new PostgreSqlPlatform();
    }
}
