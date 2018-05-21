<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Listeners;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Application\Preference\Density\DensityMeasurementPreference;
use Beeriously\Brewer\Application\Preference\Density\DensityPreferences;
use Beeriously\Brewer\Application\Preference\MassVolume\MassVolumeMeasurementPreference;
use Beeriously\Brewer\Application\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Brewer\Application\Preference\Temperature\TemperatureMeasurementPreference;
use Beeriously\Brewer\Application\Preference\Temperature\TemperaturePreferences;
use Beeriously\Brewery\Domain\Brewery;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CreateBreweryWhenBrewerRegistersListener implements EventSubscriberInterface
{
    const MASS_VOLUME_PREFERENCE_UNITS = 'massVolumePreferenceUnits';
    const DENSITY_PREFERENCE_UNITS = 'densityPreferenceUnits';
    const TEMPERATURE_PREFERENCE_UNITS = 'temperaturePreferenceUnits';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var MassVolumePreferences
     */
    private $massVolumePreferences;
    /**
     * @var DensityPreferences
     */
    private $densityPreferences;
    /**
     * @var TemperaturePreferences
     */
    private $temperaturePreferences;

    public function __construct(TranslatorInterface $translator,
                                MassVolumePreferences $massVolumePreferences,
                                DensityPreferences $densityPreferences,
                                TemperaturePreferences $temperaturePreferences,
                                EntityManagerInterface $entityManager
    ) {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
        $this->massVolumePreferences = $massVolumePreferences;
        $this->densityPreferences = $densityPreferences;
        $this->temperaturePreferences = $temperaturePreferences;
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

    protected function getMassVolumePreference(FilterUserResponseEvent $event): MassVolumeMeasurementPreference
    {
        return $this->massVolumePreferences->fromCode($this->getFromPostedForm($event, self::MASS_VOLUME_PREFERENCE_UNITS));
    }

    private function getDensityPreference($event): DensityMeasurementPreference
    {
        return $this->densityPreferences->fromCode($this->getFromPostedForm($event, self::DENSITY_PREFERENCE_UNITS));
    }

    private function getTemperaturePreference($event): TemperatureMeasurementPreference
    {
        return $this->temperaturePreferences->fromCode($this->getFromPostedForm($event, self::TEMPERATURE_PREFERENCE_UNITS));
    }

    protected function getFromPostedForm(FilterUserResponseEvent $event, string $key)
    {
        return $event->getRequest()->request->get('fos_user_registration_form')[$key];
    }
}
