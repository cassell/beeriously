<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\User;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @codeCoverageIgnore
 */
class UserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
