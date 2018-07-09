<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewery\Domain\Exception\BreweryNameCanNotBeEmptyException;
use Beeriously\Universal\Identification\String\NotEmptyStringException;

final class BreweryName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new BreweryNameCanNotBeEmptyException;
        }
        $this->value = $value;
    }

    public function equals(BreweryName $newName)
    {
        return $this->getValue() === $newName->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue()
    {
        return $this->value;
    }
}
