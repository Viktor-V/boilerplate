<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Form;

use App\Contact\Validator\Rule\ContactEmailRule;
use App\Contact\Validator\Rule\ContactMessageRule;
use App\Contact\Validator\Rule\ContactNameRule;
use App\Contact\Validator\Rule\ContactSubjectRule;
use App\Core\Infrastructure\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ContactForm extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => _('Name'),
                'required' => true,
                'constraints' => ContactNameRule::rules(),
                'attr' => [
                    'autofocus' => 'autofocus'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => _('Email'),
                'required' => true,
                'constraints' => ContactEmailRule::rules()
            ])
            ->add('subject', TextType::class, [
                'label' => _('Subject'),
                'required' => true,
                'constraints' => ContactSubjectRule::rules()
            ])
            ->add('message', TextareaType::class, [
                'label' => _('Message'),
                'required' => true,
                'constraints' => ContactMessageRule::rules()
            ]);
    }
}
