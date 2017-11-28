<?php
declare(strict_types=1);

namespace Beeriously\Controller\Tools;

use Beeriously\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HydrometerTemperatureCorrectChartController extends AbstractController
{
    /**
     * @Route("/tools/hydrometer-correction-chart", methods={"GET"})
     */
    public function view()
    {
        return $this->render('tools/hydrometer-correction-chart.html.twig',[]);
    }

}