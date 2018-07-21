<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Controller;

use Beeriously\Brewer\Domain\BrewerInterface;
use Beeriously\Universal\Event\Dispatcher;

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

    protected function addErrorMessage(string $message)
    {
        $this->addFlash('danger', $message);
    }

    protected function addSuccessMessage(string $message)
    {
        $this->addFlash('success', $message);
    }

    protected function dispatchEvents(array $events)
    {
        $this->dispatcher->dispatchEvents($events);
    }
}
