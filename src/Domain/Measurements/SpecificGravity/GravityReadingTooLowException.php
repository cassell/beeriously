<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\SpecificGravity;

class GravityReadingTooLowException extends \InvalidArgumentException
{
    public static function create($value)
    {
        return new self('Gravity reading too low '.$value);
    }
}
