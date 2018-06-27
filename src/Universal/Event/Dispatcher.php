<?php

declare(strict_types=1);

namespace Beeriously\Universal\Event;

interface Dispatcher
{
    public function dispatchEvents(array $events): void;
}
