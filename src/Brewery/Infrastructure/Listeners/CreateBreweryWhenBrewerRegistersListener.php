<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Listeners;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\Registration\Form\RegistrationForm;
use Beeriously\Brewery\Application\Preference\Density\DensityPreference;
use Beeriously\Brewery\Application\Preference\Density\DensityPreferences;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreferences;
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

    public function __construct(TranslatorInterface $translator,
                                DensityPreferences $densityPreferences,
                                TemperaturePreferences $temperaturePreferences,
                                EntityManagerInterface $entityManager,
                                RegistrationForm $form
    ) {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
        $this->densityPreferences = $densityPreferences;
        $this->temperaturePreferences = $temperaturePreferences;
        $this->form = $form;
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
            $this->translator
        );
        $this->entityManager->persist($newBrewery);
        $this->entityManager->flush();
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
