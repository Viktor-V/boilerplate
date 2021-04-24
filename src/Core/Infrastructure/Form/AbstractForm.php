<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
