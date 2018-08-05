<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Domain\Exception;

use Beeriously\Universal\Exception\SafeMessageException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class BrewerAccountAlreadyExistsException extends \RuntimeException implements SafeMessageException
{
    public function __construct(UniqueConstraintViolationException $exception)
    {
        parent::__construct('beeriously.brewer.exception.BrewerAccountAlreadyExistsException', 0, $exception);
    }
}
