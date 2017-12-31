<?php
declare(strict_types=1);

namespace Beeriously\Application\User;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}


