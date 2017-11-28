<?php
declare(strict_types=1);

namespace Beeriously\Controller;

use Beeriously\Application\Event\Event;
use Beeriously\Application\Event\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    protected function flush()
    {
        $this->getDoctrine()->getManager()->flush();
    }

    protected function publishEvents(Events $events)
    {
        foreach($events as $event) {
            $this->publishEvent($event);
        }
    }

    protected function publishEvent(Event $event)
    {
        $this->get(EventDispatcherInterface::class)->dispatch(get_class($event), $event);
    }

    protected function flushAndPublishEvents(Events $events)
    {
        $this->flush();
        $this->publishEvents($events);
    }
}