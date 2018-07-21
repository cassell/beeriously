<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreferenceFactory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class MassVolumePreferenceType extends Type
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
        return 2;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewery_mass_volume_units_preference';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): MassVolumePreference
    {
        return MassVolumePreferenceFactory::create()->fromCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof MassVolumePreference) {
            throw new \RuntimeException();
        }

        return $value->getCode();
    }
}