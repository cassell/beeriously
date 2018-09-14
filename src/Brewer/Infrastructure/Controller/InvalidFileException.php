<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Controller;

use Beeriously\Universal\Exception\SafeMessageException;

class InvalidFileException extends \RuntimeException implements SafeMessageException
{
    public function __construct()
    {
        parent::__construct('beeriously.invalid_file_exception');
    }
}
