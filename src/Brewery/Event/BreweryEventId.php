<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Event;

use Beeriously\Universal\Identification\Infrastructure\GenerateNewIdentity;
use Beeriously\Universal\Identification\String\NotEmptyStringValue;

class BreweryEventId
{
    use GenerateNewIdentity;

    /**
     * @var string
     */
    private $value;

    protected function __construct(string $value)
    {
        $this->value = (new NotEmptyStringValue($value))->getValue();
    }

    public static function fromString(string $value)
    {
        return new static($value);
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
