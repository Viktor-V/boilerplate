<?php

namespace UI\Back\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UI\Back\Request\Admin\CreatePayload;
use Symfony\Component\Form\FormBuilderInterface;

class CreateForm extends AbstractType
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

    public function getBlockPrefix()
    {
        return (string) null;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatePayload::class
        ]);
    }
}
