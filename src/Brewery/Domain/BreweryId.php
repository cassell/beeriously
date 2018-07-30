<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Universal\Identification\Infrastructure\GenerateNewIdentity;
use Beeriously\Universal\Identification\String\NotEmptyStringValue;

/**
 * Class BreweryId.
 */
final class BreweryId
{
    use GenerateNewIdentity;

    private $value;

    protected function __construct(string $value)
    {
        $this->value = (new NotEmptyStringValue($value))->getValue();
    }

    public static function fromString(string $value)
    {
        return new static($value);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
