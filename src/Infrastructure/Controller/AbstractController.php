<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Controller;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Universal\Event\Dispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function flush(): void
    {
        $this->getDoctrine()->getManager()->flush();
    }

    protected function getUser(): BrewerInterface
    {
        return parent::getUser();
    }

    protected function addErrorMessage(string $message): void
    {
        $this->addFlash('danger', $message);
    }

    protected function addSuccessMessage(string $message): void
    {
        $this->addFlash('success', $message);
    }

    protected function dispatchEvents(array $events): void
    {
        $this->dispatcher->dispatchEvents($events);
    }

    protected function renderRemoteForm(string $template, array $data): JsonResponse
    {
        return $this->successfulJson(
            [
                'content' => $this->render($template, $data)->getContent(),
            ]
        );
    }

    protected function successfulJson(array $data): JsonResponse
    {
        return $this->json([
            'error' => 0,
            'data' => $data,
        ]);
    }

    protected function getBrewery(): Brewery
    {
        return $this->getUser()->getBrewery();
    }
}
