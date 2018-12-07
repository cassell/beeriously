<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Service;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Universal\Event\Dispatcher;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Util\UserManipulator;

class RemoveBrewerFromBreweryService
{
    /**
     * @var UserManipulator
     */
    private $userManipulator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(UserManipulator $userManipulator,
                                EntityManagerInterface $entityManager,
                                Dispatcher $dispatcher
    ) {
        $this->userManipulator = $userManipulator;
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    public function removeAssistantBrewerFromBrewery(Brewer $brewer,
                                                     Brewery $brewery,
                                                     BrewerInterface $user,
                                                     OccurredOn $occurredOn)
    {
        $brewery->removeAssistantBrewer($brewer, $user, $occurredOn);

        $brewer->disassociateWithBrewery();

        $this->userManipulator->removeRole($brewer->getUsername(), 'ROLE_BREWER');
        $this->userManipulator->deactivate($brewer->getUsername());

        $this->entityManager->flush();
        $this->dispatcher->dispatchEvents($brewery->releaseEvents());
    }
}
