<?php

declare(strict_types=1);

namespace App\Common\Contact\Infrastructure\Form;

use App\Common\Contact\Validator\Rule\ContactEmailRule;
use App\Common\Contact\Validator\Rule\ContactMessageRule;
use App\Common\Contact\Validator\Rule\ContactNameRule;
use App\Common\Contact\Validator\Rule\ContactSubjectRule;
use App\Common\Contact\Infrastructure\Form\RequestObject\ContactRequestData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactForm extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add('name', TextType::class, [
            'label' => _('Name'),
            'required' => true,
            'constraints' => ContactNameRule::rules()
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactRequestData::class
        ]);
    }
}
