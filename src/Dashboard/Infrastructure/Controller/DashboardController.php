<?php

declare(strict_types=1);

namespace Beeriously\Dashboard\Infrastructure\Controller;

use Beeriously\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard", methods={"GET"})
     */
    public function view()
    {
        return $this->render('dashboard/dashboard.html.twig', []);
    }

    /**
     * @Route("/", name="root", methods={"GET"})
     */
    public function root()
    {
        return new RedirectResponse($this->generateUrl('dashboard'));
    }
}
