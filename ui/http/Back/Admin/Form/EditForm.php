<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UI\Http\Back\Admin\Request\EditPayload;

class EditForm extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add('email', EmailType::class, [
            'label' => 'Email',
            'required' => true
        ]);

        $builder->add('password', PasswordType::class, [
            'label' => 'Password',
            'required' => true
        ]);

        $builder->add('button', SubmitType::class);
    }

    public function getBlockPrefix(): string
    {
        return (string) null;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditPayload::class
        ]);
    }
}
