<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Domain\Exception;

use Beeriously\Universal\Exception\SafeMessageException;

class BrewerAccountAlreadyExistsException extends \RuntimeException implements SafeMessageException
{
    public function __construct()
    {
        parent::__construct('beeriously.brewer.exception.BrewerAccountAlreadyExistsException');
    }
}
