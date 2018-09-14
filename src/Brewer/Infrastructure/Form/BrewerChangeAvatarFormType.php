<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BrewerChangeAvatarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('avatar', FileType::class, [
            'label' => 'beeriously.profile.avatar_file',
        ]);

        $builder->add('submit', SubmitType::class, [
        ]);
    }
}
