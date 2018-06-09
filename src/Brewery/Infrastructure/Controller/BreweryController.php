<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Infrastructure\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 */
class BreweryController extends AbstractController
{
    /**
     * @Route("/brewery", name="brewery", methods={"GET"})
     */
    public function view()
    {
        return $this->render('brewery/brewery.html.twig', [
            'brewery' => $this->getUser()->getBrewery(),
        ]);
    }
}
