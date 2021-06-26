<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\HiddenFieldValidationEventSubscriber;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenFieldExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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

class FormTypeHiddenFieldExtensionTest extends TestCase
{
    private const HIDDEN_FIELD_PROTECT_FIELD = 'hidden_field';
    private const HIDDEN_FIELD_PROTECT_ENABLED = true;

    public function testBuildForm(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::once())
            ->method('addEventSubscriber')
            ->with(new HiddenFieldValidationEventSubscriber(
                $request,
                $logger,
                self::HIDDEN_FIELD_PROTECT_FIELD
            ));

        (new FormTypeHiddenFieldExtension(
            $requestStack,
            $logger,
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_field_protection' => self::HIDDEN_FIELD_PROTECT_ENABLED
            ]
        );
    }

    public function testFormIsNotBuiltAsRequestIsNull(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn(null);

        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeHiddenFieldExtension(
            $requestStack,
            $logger,
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_field_protection' => self::HIDDEN_FIELD_PROTECT_ENABLED
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

        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeHiddenFieldExtension(
            $requestStack,
            $logger,
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'hidden_field_protection' => false
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
                self::HIDDEN_FIELD_PROTECT_FIELD,
                HiddenType::class,
                [],
                [
                    'mapped' => false,
                    'label' => false,
                    'block_prefix' => self::HIDDEN_FIELD_PROTECT_FIELD
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

        (new FormTypeHiddenFieldExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_field_protection' => self::HIDDEN_FIELD_PROTECT_FIELD
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

        (new FormTypeHiddenFieldExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_field_protection' => self::HIDDEN_FIELD_PROTECT_ENABLED
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

        (new FormTypeHiddenFieldExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->finishView(
            $view,
            $form,
            [
                'hidden_field_protection' => false
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
                'hidden_field_protection' => self::HIDDEN_FIELD_PROTECT_ENABLED
            ]);

        (new FormTypeHiddenFieldExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_FIELD_PROTECT_ENABLED
        ))->configureOptions($resolver);
    }

    public function testGetExtendedTypes(): void
    {
        self::assertSame(
            [FormType::class],
            FormTypeHiddenFieldExtension::getExtendedTypes()
        );
    }
}
