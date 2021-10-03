<?php

declare(strict_types=1);

namespace App\Common\AntiSpam\Infrastructure\Form\Extension;

use App\Common\AntiSpam\Infrastructure\EventListener\HiddenCaptchaValidationEventSubscriber;
use App\Common\AntiSpam\Infrastructure\Form\Type\HiddenCaptchaType;
use App\Common\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psr\Log\LoggerInterface;

class FormTypeHiddenCaptchaExtension implements FormTypeExtensionInterface
{
    private const FIELD_NAME = 'hidden_captcha';

    public function __construct(
        private RequestStack $requestStack,
        private HiddenCaptchaValidatorInterface $hiddenCaptchaValidator,
        private LoggerInterface $logger,
        private bool $enabled
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }

        if ($options['hidden_captcha_field_protection'] === false) {
            return;
        }

        $builder
            ->addEventSubscriber(new HiddenCaptchaValidationEventSubscriber(
                $request,
                $this->hiddenCaptchaValidator,
                $this->logger,
                self::FIELD_NAME
            ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if ($view->parent) {
            return;
        }

        if ($options['hidden_captcha_field_protection'] === false) {
            return;
        }

        $factory = $form->getConfig()->getFormFactory();

        $form = $factory->createNamed(self::FIELD_NAME, HiddenCaptchaType::class, [], [
            'mapped' => false,
            'label' => false
        ]);

        $view->children[self::FIELD_NAME . '_field_name'] = $form->createView($view);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'hidden_captcha_field_protection' => $this->enabled
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        /* Empty */
    }
}
