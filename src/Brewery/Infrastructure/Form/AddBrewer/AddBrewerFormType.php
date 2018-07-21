<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\AddBrewer;

use Beeriously\Brewer\Application\Brewer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBrewerFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addUsernameField($builder);
        $this->addEmailField($builder);
        $this->addFirstNameTextField($builder);
        $this->addLastNameTextField($builder);
        $this->addPasswordMessage($builder);
        $this->addButtons($builder);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Brewer::class,
            'empty_data' => null,
        ]);
        parent::configureOptions($resolver);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addFirstNameTextField(FormBuilderInterface $builder): void
    {
        $builder->add('firstName', TextType::class, ['label' => 'beeriously.security.register.first_name']);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addLastNameTextField(FormBuilderInterface $builder): void
    {
        $builder->add('lastName', TextType::class, ['label' => 'beeriously.security.register.last_name']);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addEmailField(FormBuilderInterface $builder): void
    {
        $builder->add('email', EmailType::class, ['label' => 'form.email', 'translation_domain' => 'FOSUserBundle']);
    }

    private function addUsernameField(FormBuilderInterface $builder): void
    {
        $builder->add('username', null, ['label' => 'form.username', 'translation_domain' => 'FOSUserBundle']);
    }

    private function addPasswordMessage(FormBuilderInterface $builder): void
    {
        $builder->add('passwordMessage', HiddenType::class, [
            'mapped' => false,
            'label' => 'form.password',
            'translation_domain' => 'FOSUserBundle',
        ]);
    }

    private function addButtons(FormBuilderInterface $builder): void
    {
        $builder->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
    }
}
