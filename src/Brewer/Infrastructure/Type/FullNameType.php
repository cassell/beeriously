<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Type;

use Beeriously\Brewer\Domain\FullName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class FullNameType extends Type
{
    const MAX_LENGTH = 1000;

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
        return self::MAX_LENGTH;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewer_full_name';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): FullName
    {
        return FullName::deserialize($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof FullName) {
            throw new \RuntimeException();
        }

        $string = $value->serialize();

        if (mb_strlen($string) > self::MAX_LENGTH) {
            throw new \RuntimeException();
        }

        return $string;
    }
}
