<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BrewerySharingSettingsType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewery_sharing_settings';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BrewerySharingSettings
    {
        return BrewerySharingSettings::rehydrate(\json_decode($value, true));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof BrewerySharingSettings) {
            throw new \RuntimeException();
        }

        /* @var \Beeriously\Brewery\Settings\BrewerySharingSettings $value */
        return \json_encode($value->toArray(), JSON_FORCE_OBJECT);
    }
}
