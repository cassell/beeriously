<?php

namespace Beeriously\Domain\Generic\ValueObject\String;

class StringValue
{
    private $value;

    public function __construct(string $string = null)
    {
        $this->value = (string)$string;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}