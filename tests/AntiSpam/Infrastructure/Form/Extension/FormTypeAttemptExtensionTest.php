<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\Form\Extension;

use App\Common\AntiSpam\Infrastructure\EventListener\AttemptValidationEventSubscriber;
use App\Common\AntiSpam\Infrastructure\Form\Extension\FormTypeAttemptExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

class FormTypeAttemptExtensionTest extends TestCase
{
    private const ATTEMPT_COUNT = 10;
    private const ATTEMPT_LAST_TIME = 600;
    private const ATTEMPT_PROTECT_ENABLED = true;

    public function testBuildForm(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $cache = $this->createMock(CacheInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::once())
            ->method('addEventSubscriber')
            ->with(new AttemptValidationEventSubscriber(
                $request,
                $cache,
                $logger,
                self::ATTEMPT_COUNT,
                self::ATTEMPT_LAST_TIME
            ));

        (new FormTypeAttemptExtension(
            $requestStack,
            $cache,
            $logger,
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME,
            self::ATTEMPT_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'attempt_count' => self::ATTEMPT_COUNT,
                'attempt_last_time' => self::ATTEMPT_LAST_TIME,
                'attempt_protection' => self::ATTEMPT_PROTECT_ENABLED
            ]
        );
    }

    public function testFormIsNotBuiltAsRequestIsNull(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn(null);

        $cache = $this->createMock(CacheInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeAttemptExtension(
            $requestStack,
            $cache,
            $logger,
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME,
            self::ATTEMPT_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'attempt_count' => self::ATTEMPT_COUNT,
                'attempt_last_time' => self::ATTEMPT_LAST_TIME,
                'attempt_protection' => self::ATTEMPT_PROTECT_ENABLED
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

        $cache = $this->createMock(CacheInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::never())
            ->method('addEventSubscriber');

        (new FormTypeAttemptExtension(
            $requestStack,
            $cache,
            $logger,
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME,
            false
        ))->buildForm(
            $builder,
            [
                'attempt_count' => self::ATTEMPT_COUNT,
                'attempt_last_time' => self::ATTEMPT_LAST_TIME,
                'attempt_protection' => false
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
                'attempt_protection' => self::ATTEMPT_PROTECT_ENABLED,
                'attempt_count' => self::ATTEMPT_COUNT,
                'attempt_last_time' => self::ATTEMPT_PROTECT_ENABLED
            ]);

        (new FormTypeAttemptExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(CacheInterface::class),
            $this->createMock(LoggerInterface::class),
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME,
            self::ATTEMPT_PROTECT_ENABLED
        ))->configureOptions($resolver);
    }

    public function testGetExtendedTypes(): void
    {
        self::assertSame(
            [FormType::class],
            FormTypeAttemptExtension::getExtendedTypes()
        );
    }
}
