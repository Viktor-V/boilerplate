<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\Form\Extension;

use App\Common\AntiSpam\Infrastructure\EventListener\HiddenCaptchaValidationEventSubscriber;
use App\Common\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenCaptchaExtension;
use App\Common\AntiSpam\Infrastructure\Form\Type\HiddenCaptchaType;
use App\Common\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FormTypeHiddenCaptchaExtensionTest extends TestCase
{
    private const HIDDEN_CAPTCHA_PROTECT_FIELD = 'hidden_captcha';
    private const HIDDEN_CAPTCHA_PROTECT_ENABLED = true;

    public function testBuildForm(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::once())
            ->method('addEventSubscriber')
            ->with(new HiddenCaptchaValidationEventSubscriber(
                $request,
                $hiddenCaptchaValidator,
                $logger,
                self::HIDDEN_CAPTCHA_PROTECT_FIELD
            ));

        (new FormTypeHiddenCaptchaExtension(
            $requestStack,
            $hiddenCaptchaValidator,
            $logger,
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_captcha_field_protection' => self::HIDDEN_CAPTCHA_PROTECT_ENABLED
            ]
        );
    }

    public function testFormIsNotBuiltAsRequestIsNull(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn(null);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeHiddenCaptchaExtension(
            $requestStack,
            $hiddenCaptchaValidator,
            $logger,
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_captcha_field_protection' => self::HIDDEN_CAPTCHA_PROTECT_ENABLED
            ]
        );
    }

    public function testFormIsNotBuiltAsProtectionIsDisabled(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeHiddenCaptchaExtension(
            $requestStack,
            $hiddenCaptchaValidator,
            $logger,
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_captcha_field_protection' => false
            ]
        );
    }

    public function testFinishView(): void
    {
        $view = $this->createMock(FormView::class);
        $view->parent = null;

        $hashField = $this->createMock(FormInterface::class);
        $hashField
            ->expects(self::once())
            ->method('createView')
            ->with($view);

        $formFactory = $this->createMock(FormFactoryInterface::class);
        $formFactory
            ->expects(self::once())
            ->method('createNamed')
            ->with(
                self::HIDDEN_CAPTCHA_PROTECT_FIELD,
                HiddenCaptchaType::class,
                [],
                [
                    'mapped' => false,
                    'label' => false
                ]
            )
            ->willReturn($hashField);

        $formConfig = $this->createMock(FormConfigInterface::class);
        $formConfig
            ->expects(self::once())
            ->method('getFormFactory')
            ->willReturn($formFactory);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('getConfig')
            ->willReturn($formConfig);

        (new FormTypeHiddenCaptchaExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(HiddenCaptchaValidatorInterface::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_captcha_field_protection' => self::HIDDEN_CAPTCHA_PROTECT_ENABLED
            ]
        );
    }

    public function testViewIsNotBuiltAsViewIsParent(): void
    {
        $view = $this->createMock(FormView::class);
        $view->parent = $this->createMock(FormView::class);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::never())
            ->method('getConfig');

        (new FormTypeHiddenCaptchaExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(HiddenCaptchaValidatorInterface::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_captcha_field_protection' => self::HIDDEN_CAPTCHA_PROTECT_ENABLED
            ]
        );
    }

    public function testViewIsNotBuiltAsProtectionIsDisabled(): void
    {
        $view = $this->createMock(FormView::class);
        $view->parent = null;

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::never())
            ->method('getConfig');

        (new FormTypeHiddenCaptchaExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(HiddenCaptchaValidatorInterface::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_captcha_field_protection' => false
            ]
        );
    }

    public function testConfigureOptions(): void
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver
            ->expects(self::once())
            ->method('setDefaults')
            ->with([
                'hidden_captcha_field_protection' => self::HIDDEN_CAPTCHA_PROTECT_ENABLED
            ]);

        (new FormTypeHiddenCaptchaExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(HiddenCaptchaValidatorInterface::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_PROTECT_ENABLED
        ))->configureOptions($resolver);
    }

    public function testGetExtendedTypes(): void
    {
        self::assertSame(
            [FormType::class],
            FormTypeHiddenCaptchaExtension::getExtendedTypes()
        );
    }
}
