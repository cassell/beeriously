<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewery\Brewery;
use Beeriously\Infrastructure\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SharedBeerMenuController extends AbstractController
{
    /**
     * @Route("/public/{id}/beer-menu", name="brewery-shared-beer-menu", methods={"GET","POST"})
     */
    public function sharedTapList(Brewery $brewery)
    {
        throw new \RuntimeException('TODO');
    }
}
