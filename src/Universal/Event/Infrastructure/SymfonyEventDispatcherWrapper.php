<?php

declare(strict_types=1);

namespace Beeriously\Universal\Event\Infrastructure;

use Beeriously\Universal\Event\Dispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SymfonyEventDispatcherWrapper implements Dispatcher
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatchEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($this->convertEventToClassName($event), $event);
        }
    }

    private function convertEventToClassName($event): string
    {
        return \get_class($event);
    }
}
