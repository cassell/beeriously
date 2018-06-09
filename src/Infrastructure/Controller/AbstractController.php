<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Controller;

use Beeriously\Application\Event\Event;
use Beeriously\Application\Event\Events;
use Beeriously\Brewer\Domain\BrewerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @codeCoverageIgnore
 */
class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    protected function flush(): void
    {
        $this->getDoctrine()->getManager()->flush();
    }

    protected function getUser(): BrewerInterface
    {
        return parent::getUser();
    }

//    protected function publishEvents(Events $events): void
//    {
//        foreach ($events as $event) {
//            $this->publishEvent($event);
//        }
//    }
//
//    protected function publishEvent(Event $event): Event
//    {
//        return $this->get(EventDispatcherInterface::class)->dispatch(get_class($event), $event);
//    }
//
//    protected function flushAndPublishEvents(Events $events): void
//    {
//        $this->flush();
//        $this->publishEvents($events);
//    }
}
