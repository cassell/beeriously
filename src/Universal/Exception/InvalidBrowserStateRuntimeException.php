<?php

declare(strict_types=1);

namespace Beeriously\Universal\Exception;

use Throwable;

class InvalidBrowserStateRuntimeException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
