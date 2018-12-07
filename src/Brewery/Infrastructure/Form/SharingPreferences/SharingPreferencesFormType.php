<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\SharingPreferences;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SharingPreferencesFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tapBeerList', CheckboxType::class, [
            'label' => 'beeriously.brewery.sharing_settings.tap_list',
            'required' => false,
        ]);
        $builder->add('submit', SubmitType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SharingPreferencesData::class,
        ]);
        parent::configureOptions($resolver);
    }
}
