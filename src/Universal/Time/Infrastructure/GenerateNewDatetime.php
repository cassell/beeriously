<?php

declare(strict_types=1);

namespace Beeriously\Universal\Time\Infrastructure;

trait GenerateNewDatetime
{
    abstract public function __construct(\DateTimeImmutable $dateTimeImmutable);

    public static function now(): self
    {
        return new self(new \DateTimeImmutable());
    }
}
