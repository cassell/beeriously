<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Registration\Form;

use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreference;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreferenceFactory;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreferences;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Brewery\Preference\Density\DensityPreference;
use Beeriously\Brewery\Preference\Density\DensityPreferenceFactory;
use Beeriously\Brewery\Preference\Density\DensityPreferences;
use Beeriously\Brewery\Preference\Density\SpecificGravityPreference;
use Beeriously\Brewery\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreferenceFactory;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreferences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class RegistrationForm extends AbstractType
{
    const MASS_VOLUME_PREFERENCE_UNITS = 'massVolumePreferenceUnits';
    const DENSITY_PREFERENCE_UNITS = 'densityPreferenceUnits';
    const TEMPERATURE_PREFERENCE_UNITS = 'temperaturePreferenceUnits';

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
    /**
     * @var MassVolumePreferenceFactory
     */
    private $massVolumePreferenceFactory;
    /**
     * @var DensityPreferenceFactory
     */
    private $densityPreferenceFactory;
    /**
     * @var TemperaturePreferenceFactory
     */
    private $temperaturePreferenceFactory;

    public function __construct(MassVolumePreferences $massVolumePreferences,
                                MassVolumePreferenceFactory $massVolumePreferenceFactory,
                                DensityPreferences $densityPreferences,
                                DensityPreferenceFactory $densityPreferenceFactory,
                                TemperaturePreferences $temperaturePreferences,
                                TemperaturePreferenceFactory $temperaturePreferenceFactory,
                                TranslatorInterface $translator)
    {
        $this->massVolumePreferences = $massVolumePreferences;
        $this->massVolumePreferenceFactory = $massVolumePreferenceFactory;
        $this->densityPreferences = $densityPreferences;
        $this->densityPreferenceFactory = $densityPreferenceFactory;
        $this->temperaturePreferences = $temperaturePreferences;
        $this->temperaturePreferenceFactory = $temperaturePreferenceFactory;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addFirstNameTextField($builder);

        $this->addLastNameTextField($builder);

        $this->addMassVolumePreferenceSelect($builder);

        $this->addTemperaturePreferenceSelect($builder);

        $this->addDensityPreferenceSelect($builder);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getMassVolumeSubmittedUnitsCode(Request $request): string
    {
        return $this->getFromPostedForm($request->request, self::MASS_VOLUME_PREFERENCE_UNITS);
    }

    protected function getFromPostedForm(\Symfony\Component\HttpFoundation\ParameterBag $parameterBag, string $key)
    {
        return $parameterBag->get('fos_user_registration_form')[$key];
    }

    public function getMassVolumePreferenceSubmitted(Request $request): MassVolumePreference
    {
        return $this->massVolumePreferenceFactory->fromCode(
            $this->getFromPostedForm($request->request, self::MASS_VOLUME_PREFERENCE_UNITS)
        );
    }

    public function getDensityPreferenceSubmitted(Request $request): DensityPreference
    {
        return $this->densityPreferenceFactory->fromCode(
            $this->getFromPostedForm($request->request, self::DENSITY_PREFERENCE_UNITS)
        );
    }

    public function getTemperaturePreferenceSubmitted(Request $request): TemperaturePreference
    {
        return $this->temperaturePreferenceFactory->fromCode(
            $this->getFromPostedForm($request->request, self::TEMPERATURE_PREFERENCE_UNITS)
        );
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addFirstNameTextField(FormBuilderInterface $builder): void
    {
        $builder->add('firstName', TextType::class, [
            'label' => $this->translator->trans('beeriously.security.register.first_name'),
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addLastNameTextField(FormBuilderInterface $builder): void
    {
        $builder->add('lastName', TextType::class, [
            'label' => 'beeriously.security.register.last_name',
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addMassVolumePreferenceSelect(FormBuilderInterface $builder): void
    {
        $massVolumeUnits = [];
        foreach ($this->massVolumePreferences as $massVolumePreference) {
            $massVolumeUnits[$this->translator->trans($massVolumePreference->getTranslationDescriptionIdentifier())] = $massVolumePreference->getCode();
        }
        $builder->add(self::MASS_VOLUME_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $massVolumeUnits,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false,
            'data' => (new UnitedStatesCustomarySystemPreference())->getCode(), //default
            'label' => 'beeriously.measurements.mass_volume.description',
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addDensityPreferenceSelect(FormBuilderInterface $builder): void
    {
        $densityUnits = [];
        foreach ($this->densityPreferences as $densityPreference) {
            $densityUnits[$this->translator->trans($densityPreference->getTranslationDescriptionIdentifier())] = $densityPreference->getCode();
        }
        $builder->add(self::DENSITY_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $densityUnits,
            'expanded' => true,
            'multiple' => false,
            'help' => 'beeriously.measurements.density.help_text',
            'mapped' => false,
            'data' => (new SpecificGravityPreference())->getCode(), // default
            'label' => 'beeriously.measurements.density.description',
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addTemperaturePreferenceSelect(FormBuilderInterface $builder): void
    {
        $temperatureUnits = [];
        foreach ($this->temperaturePreferences as $temperaturePreference) {
            $temperatureUnits[$this->translator->trans($temperaturePreference->getTranslationDescriptionIdentifier())] = $temperaturePreference->getCode();
        }
        $builder->add(self::TEMPERATURE_PREFERENCE_UNITS, ChoiceType::class, [
            'choices' => $temperatureUnits,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false,
            'data' => (new FahrenheitPreference())->getCode(),
            'label' => 'beeriously.measurements.temperature.description',
        ]);
    }
}
