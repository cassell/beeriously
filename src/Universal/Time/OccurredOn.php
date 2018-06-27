<?php

declare(strict_types=1);

namespace Beeriously\Universal\Time;

use Beeriously\Universal\Time\Infrastructure\GenerateNewDatetime;

final class OccurredOn
{
    use GenerateNewDatetime;

    /**
     * @var \DateTimeImmutable
     */
    private $dateTimeImmutable;

    public function __construct(\DateTimeImmutable $dateTimeImmutable)
    {
        $this->dateTimeImmutable = $dateTimeImmutable;
    }

    public function toDatetimeImmutable()
    {
        return $this->dateTimeImmutable;
    }
}
