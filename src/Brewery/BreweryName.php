<?php

declare(strict_types=1);

namespace Beeriously\Brewery;

use Beeriously\Brewery\Exception\BreweryNameCanNotBeEmptyException;

final class BreweryName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new BreweryNameCanNotBeEmptyException();
        }
        $this->value = $value;
    }

    public function equals(self $newName)
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
