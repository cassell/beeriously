<?php

declare(strict_types=1);

namespace Beeriously\Domain\Generic\ValueObject;

use Beeriously\Domain\Generic\ValueObject\String\NotEmptyStringValue;
use Ramsey\Uuid\Uuid;

class Identifier
{
    /**
     * @var string
     */
    private $value;

    protected function __construct(string $value)
    {
        $this->value = (new NotEmptyStringValue($value))->getValue();
    }

    public static function newId()
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromString(string $value)
    {
        return new static($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
