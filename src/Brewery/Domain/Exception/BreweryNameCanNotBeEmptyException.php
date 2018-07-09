<?php
declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Exception;

use Beeriously\Universal\Exception\SafeMessageException;

class BreweryNameCanNotBeEmptyException extends \RuntimeException implements SafeMessageException
{
    public function __construct()
    {
        parent::__construct('beeriously.brewery.exception.BreweryNameCanNotBeEmptyException');
    }

}