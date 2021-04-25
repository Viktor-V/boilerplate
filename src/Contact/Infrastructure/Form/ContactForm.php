<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Form;

use App\Contact\Validator\Rule\ContactEmailRule;
use App\Contact\Validator\Rule\ContactMessageRule;
use App\Contact\Validator\Rule\ContactNameRule;
use App\Contact\Validator\Rule\ContactSubjectRule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ContactForm extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add('name', TextType::class, [
            'label' => _('Name'),
            'required' => true,
            'constraints' => ContactNameRule::rules(),
            'attr' => [
                'autofocus' => 'autofocus'
            ]
        ]);

        $builder->add('email', TextType::class, [
            'label' => _('Email'),
            'required' => true,
            'constraints' => ContactEmailRule::rules()
        ]);

        $builder->add('subject', TextType::class, [
            'label' => _('Subject'),
            'required' => true,
            'constraints' => ContactSubjectRule::rules()
        ]);

       $builder->add('message', TextareaType::class, [
           'label' => _('Message'),
           'required' => true,
           'constraints' => ContactMessageRule::rules()
       ]);
    }
}
