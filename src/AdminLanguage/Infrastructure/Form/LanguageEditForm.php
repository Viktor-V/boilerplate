<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Form;

use App\Core\Admin\Infrastructure\Form\AbstractForm;
use App\AdminLanguage\Validator\Rule\Language\LanguageNameRule;
use App\AdminLanguage\Validator\Rule\Language\LanguageNativeRule;
use App\AdminLanguage\ValueObject\LanguageEditRequestData;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageEditForm extends AbstractForm
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->setMethod('put');

        $builder->add('code', TextType::class, [
            'label' => _a('Code'),
            'required' => false,
            'disabled' => true
        ]);

        $builder->add('name', TextType::class, [
            'label' => _a('Name'),
            'required' => true,
            'constraints' => LanguageNameRule::rules()
        ]);

        $builder->add('native', TextType::class, [
            'label' => _a('Native'),
            'required' => true,
            'constraints' => LanguageNativeRule::rules()
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', LanguageEditRequestData::class);
    }
}
