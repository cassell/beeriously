<?php

declare(strict_types=1);

namespace Beeriously\Controller;

use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function view()
    {
        return $this->render('dashboard/dashboard.html.twig', []);
    }
}
