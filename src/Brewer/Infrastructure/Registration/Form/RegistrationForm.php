<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Registration\Form;

use Beeriously\Brewer\Application\Preference\Density\DensityPreferences;
use Beeriously\Brewer\Application\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Brewer\Application\Preference\Temperature\TemperaturePreferences;
use Beeriously\Brewery\Infrastructure\Listeners\CreateBreweryWhenBrewerRegistersListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class RegistrationForm extends AbstractType
{
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
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(MassVolumePreferences $massVolumePreferences,
                                DensityPreferences $densityPreferences,
                                TemperaturePreferences $temperaturePreferences,
                                TranslatorInterface $translator)
    {
        $this->massVolumePreferences = $massVolumePreferences;
        $this->densityPreferences = $densityPreferences;
        $this->temperaturePreferences = $temperaturePreferences;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => $this->translator->trans('beeriously.security.register.first_name'),
        ]);
        $builder->add('lastName', TextType::class, [
            'label' => $this->translator->trans('beeriously.security.register.last_name'),
        ]);

        $massVolumeUnits = [];
        foreach ($this->massVolumePreferences as $massVolumePreference) {
            $massVolumeUnits[$this->translator->trans($massVolumePreference->getTranslationDescriptionIdentifier())] = $massVolumePreference->getCode();
        }
        $builder->add(CreateBreweryWhenBrewerRegistersListener::MASS_VOLUME_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $massVolumeUnits,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false,
            'label' => $this->translator->trans('beeriously.measurements.mass_volume.description'),
        ]);

        $densityUnits = [];
        foreach ($this->densityPreferences as $densityPreference) {
            $densityUnits[$this->translator->trans($densityPreference->getTranslationDescriptionIdentifier())] = $densityPreference->getCode();
        }
        $builder->add(CreateBreweryWhenBrewerRegistersListener::DENSITY_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $densityUnits,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false,
            'label' => $this->translator->trans('beeriously.measurements.density.description'),
        ]);

        $temperatureUnits = [];
        foreach ($this->temperaturePreferences as $temperaturePreference) {
            $temperatureUnits[$this->translator->trans($temperaturePreference->getTranslationDescriptionIdentifier())] = $temperaturePreference->getCode();
        }
        $builder->add(CreateBreweryWhenBrewerRegistersListener::TEMPERATURE_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $temperatureUnits,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false,
            'label' => $this->translator->trans('beeriously.measurements.temperature.description'),
        ]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
