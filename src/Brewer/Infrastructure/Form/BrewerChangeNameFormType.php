<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class BrewerChangeNameFormType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addFirstNameTextField($builder);

        $this->addLastNameTextField($builder);

        $builder->add('submit', SubmitType::class, [
        ]);
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
}
