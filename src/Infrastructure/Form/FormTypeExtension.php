<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

// https://stackoverflow.com/questions/14756362/symfony2-form-validation-with-html5-and-cancel-button#16992515
class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined('cancel_action');
        $resolver->setAllowedTypes('cancel_action', 'string');

        $resolver->setDefined('cancel_button_align_right');
        $resolver->setAllowedTypes('cancel_button_align_right', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (isset($options['cancel_action'])) {
            $view->vars['cancel_action'] = $options['cancel_action'];
        }

        if (isset($options['cancel_button_align_right'])) {
            $view->vars['cancel_button_align_right'] = $options['cancel_button_align_right'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return FormType::class;
    }
}
