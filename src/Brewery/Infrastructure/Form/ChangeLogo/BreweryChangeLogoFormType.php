<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\ChangeLogo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BreweryChangeLogoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('logo', FileType::class, [
            'label' => 'beeriously.brewery.logo.logo_file',
        ]);

        $builder->add('submit', SubmitType::class, [
        ]);
    }
}
