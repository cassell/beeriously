<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmModalMessageFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined('confirm_message_title');
        $resolver->setAllowedTypes('confirm_message_title', 'string');

        $resolver->setDefined('submit_button_class');
        $resolver->setAllowedTypes('submit_button_class', 'string');

        $resolver->setDefined('submit_button_text');
        $resolver->setAllowedTypes('submit_button_text', 'string');

        $resolver->setDefined('cancel_button_text');
        $resolver->setAllowedTypes('cancel_button_text', 'string');
    }

    public function getBlockPrefix()
    {
        return 'confirm_modal_message';
    }

    public function getParent()
    {
        return HiddenType::class;
    }
}
