<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiddenCaptchaType implements FormTypeInterface
{
    private const NAME = 'hidden_captcha';

    public function __construct(
        private string $type,
        private string $publicKey
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /* Empty */
    }

    public function buildView(
        FormView $view,
        FormInterface $form,
        array $options
    ): void {
        $view->vars = array_merge([
            'captcha_type' => $this->type,
            'public_key' => $this->publicKey
        ], $view->vars);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            /* Empty */
        ]);
    }

    public function getBlockPrefix(): string
    {
        return self::NAME;
    }

    public function getParent(): string
    {
        return HiddenType::class;
    }

    public function finishView(
        FormView $view,
        FormInterface $form,
        array $options
    ): void {
        /* Empty */
    }
}
