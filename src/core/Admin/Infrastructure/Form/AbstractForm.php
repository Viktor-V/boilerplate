<?php

declare(strict_types=1);

namespace App\Core\Admin\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('attempt_protection', false);
        $resolver->setDefault('crawler_protection', false);
        $resolver->setDefault('hash_field_protection', false);
        $resolver->setDefault('hidden_captcha_field_protection', false);
        $resolver->setDefault('hidden_field_protection', false);
    }
}
