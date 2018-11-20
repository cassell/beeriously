<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\BreweryId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BreweryIdType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration = array_merge($fieldDeclaration,
            [
                'length' => $this->getDefaultLength($platform),
            ]);

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 36;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewery_id';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ? BreweryId
    {
        if (null === $value) {
            return null;
        }

        return BreweryId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof BreweryId) {
            throw new \RuntimeException();
        }

        return $value->getValue();
    }
}
