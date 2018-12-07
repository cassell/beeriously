<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\BrewerySharingPreferences;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BrewerySharingPreferencesType extends Type
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
        return 'beeriously_brewery_sharing_preferences';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BrewerySharingPreferences
    {
        return BrewerySharingPreferences::rehydrate(\json_decode($value, true));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof BrewerySharingPreferences) {
            throw new \RuntimeException();
        }

        /* @var BrewerySharingPreferences $value */
        return \json_encode($value->toArray(), JSON_FORCE_OBJECT);
    }
}
