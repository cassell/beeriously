<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Listeners;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Domain\Brewery;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CreateBreweryWhenBrewerRegistersListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator,
                                EntityManagerInterface $entityManager
    ) {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
        ];
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        /** @var Brewer $brewer */
        $brewer = $event->getUser();
        $newOrganization = Brewery::fromBrewer($brewer, $this->translator);
        $this->entityManager->persist($newOrganization);
        $this->entityManager->flush();
    }
}
