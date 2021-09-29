<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Form;

use App\AdminCore\Infrastructure\Form\AbstractForm;
use App\AdminLanguage\Validator\Rule\Language\LanguageCodeRule;
use App\AdminLanguage\Validator\Rule\Language\LanguageNameRule;
use App\AdminLanguage\Validator\Rule\Language\LanguageNativeRule;
use App\AdminLanguage\ValueObject\LanguageCreateRequestData;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LanguageCreateForm extends AbstractForm
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->setMethod('post');

        $builder->add('code', LanguageType::class, [
            'label' => _a('Code'),
            'required' => true,
            'constraints' => LanguageCodeRule::rules(),
            'preferred_choices' => ['en', 'ru', 'lv']
        ]);

        $nameRules = LanguageNativeRule::rules();
        unset($nameRules[array_search(NotBlank::class, $nameRules, true)]);

        $builder->add('name', TextType::class, [
            'label' => _a('Name'),
            'required' => false,
            'constraints' => $nameRules
        ]);

        $nativeRules = LanguageNativeRule::rules();
        unset($nativeRules[array_search(NotBlank::class, $nativeRules, true)]);

        $builder->add('native', TextType::class, [
            'label' => _a('Native'),
            'required' => false,
            'constraints' => $nativeRules
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', LanguageCreateRequestData::class);
    }
}
