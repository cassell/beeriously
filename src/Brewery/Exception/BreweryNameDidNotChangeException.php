<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Exception;

use Beeriously\Universal\Exception\SafeMessageException;

class BreweryNameDidNotChangeException extends \RuntimeException implements SafeMessageException
{
    public function __construct()
    {
        parent::__construct('beeriously.brewery.exception.BreweryNameDidNotChangeException');
    }
}
