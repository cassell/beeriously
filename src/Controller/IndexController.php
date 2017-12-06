<?php

declare(strict_types=1);

namespace Beeriously\Controller;

use Beeriously\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function view()
    {
       return new RedirectResponse('/tools/hydrometer-correction-chart');
    }
}
