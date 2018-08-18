<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Listeners;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\Registration\Form\RegistrationForm;
use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\DensityPreference;
use Beeriously\Brewery\Application\Preference\Density\DensityPreferences;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreferences;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Event\Dispatcher;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreateBreweryWhenBrewerRegistersListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var DensityPreferences
     */
    private $densityPreferences;
    /**
     * @var TemperaturePreferences
     */
    private $temperaturePreferences;
    /**
     * @var RegistrationForm
     */
    private $form;

    /**
     * @var BreweryNameFactory
     */
    private $breweryNameFactory;
    /**
     * @var Dispatcher
     */
    private $dispatcher;
    /**
     * @var UserManipulator
     */
    private $userManipulator;

    public function __construct(BreweryNameFactory $breweryNameFactory,
                                DensityPreferences $densityPreferences,
                                TemperaturePreferences $temperaturePreferences,
                                EntityManagerInterface $entityManager,
                                Dispatcher $dispatcher,
                                UserManipulator $userManipulator,
                                RegistrationForm $form
    ) {
        $this->entityManager = $entityManager;
        $this->densityPreferences = $densityPreferences;
        $this->temperaturePreferences = $temperaturePreferences;
        $this->form = $form;
        $this->breweryNameFactory = $breweryNameFactory;
        $this->dispatcher = $dispatcher;
        $this->userManipulator = $userManipulator;
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

        $newBrewery = Brewery::fromBrewer(
            $brewer,
            $this->getMassVolumePreference($event),
            $this->getDensityPreference($event),
            $this->getTemperaturePreference($event),
            OccurredOn::now(),
            $this->breweryNameFactory
        );

        $brewer->addRole(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

        $this->entityManager->persist($newBrewery);
        $this->entityManager->flush();

        $this->dispatcher->dispatchEvents($newBrewery->releaseEvents());
    }

    protected function getMassVolumePreference(FilterUserResponseEvent $event): MassVolumePreference
    {
        return $this->form->getMassVolumePreferenceSubmitted($event->getRequest());
    }

    private function getDensityPreference(FilterUserResponseEvent $event): DensityPreference
    {
        return $this->form->getDensityPreferenceSubmitted($event->getRequest());
    }

    private function getTemperaturePreference(FilterUserResponseEvent $event): TemperaturePreference
    {
        return $this->form->getTemperaturePreferenceSubmitted($event->getRequest());
    }
}
