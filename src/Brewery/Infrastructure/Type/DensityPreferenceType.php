<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\Preference\Density\DensityPreference;
use Beeriously\Brewery\Preference\Density\DensityPreferenceFactory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DensityPreferenceType extends Type
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
        return 5;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewery_density_units_preference';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DensityPreference
    {
        return DensityPreferenceFactory::create()->fromCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof DensityPreference) {
            throw new \RuntimeException();
        }

        return $value->getCode();
    }
}
