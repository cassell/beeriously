<?php

declare(strict_types=1);

namespace Beeriously\Controller\Calculations;

use Beeriously\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HydrometerTemperatureCorrectChartController extends AbstractController
{
    /**
     * @Route("/calculations/hydrometer-correction-chart", methods={"GET"})
     */
    public function view(Request $request): Response
    {
        $correctedValues = [];

        return $this->render('calculations/hydrometer-correction-chart.html.twig', [
            'correctedValues' => $correctedValues,
        ]);
    }
}
