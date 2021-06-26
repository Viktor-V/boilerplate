<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\EventListener;

use App\AntiSpam\Infrastructure\EventListener\AttemptValidationEventSubscriber;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Cache\ItemInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AttemptValidationEventSubscriberTest extends TestCase
{
    private const ATTEMPT_COUNT = 10;
    private const ATTEMPT_LAST_TIME = 600;

    public function testFormIsNotRoot(): void
    {
        $request = $this->createMock(Request::class);
        $cache = $this->createMock(ArrayAdapter::class);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(false);
        $form
            ->expects(self::never())
            ->method('isValid');

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);

        (new AttemptValidationEventSubscriber(
            $request,
            $cache,
            $this->createMock(LoggerInterface::class),
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME
        ))->postSubmit($event);
    }

    public function testFormIsNotValid(): void
    {
        $request = $this->createMock(Request::class);
        $cache = $this->createMock(ArrayAdapter::class);
        $cache
            ->expects(self::never())
            ->method('getItem');

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(true);
        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(false);

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);

        (new AttemptValidationEventSubscriber(
            $request,
            $cache,
            $this->createMock(LoggerInterface::class),
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME
        ))->postSubmit($event);
    }

    public function testUserIsBot(): void
    {
        $request = $this->createMock(Request::class);
        $request->headers = $this->createMock(HeaderBag::class);

        $item = $this->createMock(ItemInterface::class);
        $item
            ->expects(self::once())
            ->method('get')
            ->willReturn(10);

        $cache = $this->createMock(ArrayAdapter::class);
        $cache
            ->expects(self::once())
            ->method('getItem')
            ->willReturn($item);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(true);
        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true);
        $form
            ->expects(self::once())
            ->method('addError')
            ->willReturn(
                new FormError(
                    'You have sent too many requests in a given amount of time. Please, try again after 1 hour.'
                )
            );

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);

        (new AttemptValidationEventSubscriber(
            $request,
            $cache,
            $this->createMock(LoggerInterface::class),
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME
        ))->postSubmit($event);
    }

    public function testUserIsNotBot(): void
    {
        $request = $this->createMock(Request::class);
        $request
            ->method('getSession')
            ->willReturn($this->createMock(SessionInterface::class));
        $request->headers = $this->createMock(HeaderBag::class);

        $item = $this->createMock(ItemInterface::class);
        $item
            ->expects(self::once())
            ->method('get')
            ->willReturn(0);

        $cache = $this->createMock(ArrayAdapter::class);
        $cache
            ->expects(self::once())
            ->method('getItem')
            ->willReturn($item);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(true);
        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true);
        $form
            ->expects(self::never())
            ->method('addError');

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);

        (new AttemptValidationEventSubscriber(
            $request,
            $cache,
            $this->createMock(LoggerInterface::class),
            self::ATTEMPT_COUNT,
            self::ATTEMPT_LAST_TIME
        ))->postSubmit($event);
    }
}
