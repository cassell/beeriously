<?php

declare(strict_types=1);

namespace Beeriously\Controller\Calculations;

use Beeriously\Infrastructure\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalculationsController extends AbstractController
{
    /**
     * @Route("/calculations", name="calculations", methods={"GET"})
     */
    public function view()
    {
        return $this->render('calculations/index.html.twig', []);
    }
}
