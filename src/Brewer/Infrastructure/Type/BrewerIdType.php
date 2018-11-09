<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Type;

use Beeriously\Brewer\BrewerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BrewerIdType extends Type
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
        return 'beeriously_brewer_id';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ? BrewerId
    {
        if (null === $value) {
            return null;
        }

        return BrewerId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof BrewerId) {
            throw new \RuntimeException();
        }

        return $value->getValue();
    }
}
