<?php

declare(strict_types=1);

namespace Beeriously\Universal\Identification\Infrastructure;

use Ramsey\Uuid\Uuid;

trait GenerateNewIdentity
{
    abstract protected function __construct(string $value);

    public static function newId(): self
    {
        return new static(Uuid::uuid4()->toString());
    }
}
