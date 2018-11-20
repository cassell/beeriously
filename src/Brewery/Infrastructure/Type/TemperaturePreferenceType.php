<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Type;

use Beeriously\Brewery\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreferenceFactory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TemperaturePreferenceType extends Type
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
        return 1;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'beeriously_brewery_temperature_units_preference';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): TemperaturePreference
    {
        return TemperaturePreferenceFactory::create()->fromCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof TemperaturePreference) {
            throw new \RuntimeException();
        }

        return $value->getCode();
    }
}
