<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\File;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class StorageKeyType extends Type
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
        return 255;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_storage_key';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ? StorageKey
    {
        if (null === $value) {
            return null;
        }

        return new StorageKey($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof StorageKey) {
            throw new \RuntimeException();
        }

        return $value->getValue();
    }
}
