<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Controller;

use Beeriously\Brewer\Domain\BrewerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    protected function flush(): void
    {
        $this->getDoctrine()->getManager()->flush();
    }

    protected function getUser(): BrewerInterface
    {
        return parent::getUser();
    }
}
