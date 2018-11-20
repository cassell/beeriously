<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Event\Dispatcher;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 */
class BreweryController extends AbstractController
{
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct($dispatcher);
    }

    /**
     * @Route("/brewery", name="brewery", methods={"GET","POST"})
     */
    public function view(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->render('brewery/brewery.html.twig', [
            'brewery' => $this->getBrewery(),
        ]);
    }
}
