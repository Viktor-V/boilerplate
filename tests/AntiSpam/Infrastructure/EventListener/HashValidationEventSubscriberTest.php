<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\EventListener;

use App\Common\AntiSpam\Infrastructure\EventListener\HashValidationEventSubscriber;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class HashValidationEventSubscriberTest extends TestCase
{
    private const HASH_FIELD = 'hash';

    public function testFormIsNotRoot(): void
    {
        $request = $this->createMock(Request::class);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(false);

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);
        $event
            ->expects(self::never())
            ->method('getData');

        (new HashValidationEventSubscriber(
            $request,
            $this->createMock(LoggerInterface::class),
            self::HASH_FIELD
        ))->preSubmit($event);
    }

    public function testUserIsBot(): void
    {
        $request = $this->createMock(Request::class);
        $request->headers = $this->createMock(HeaderBag::class);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(true);
        $form
            ->expects(self::once())
            ->method('addError')
            ->willReturn(
                new FormError(
                    'Oops. Something went wrong. Please, try later.'
                )
            );

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);
        $event
            ->expects(self::once())
            ->method('getData')
            ->willReturn([
                self::HASH_FIELD => 'inputwronghashedvalue'
            ]);

        (new HashValidationEventSubscriber(
            $request,
            $this->createMock(LoggerInterface::class),
            self::HASH_FIELD
        ))->preSubmit($event);
    }

    public function testUserIsNotBot(): void
    {
        $request = $this->createMock(Request::class);

        $form = $this->createMock(FormInterface::class);
        $form
            ->expects(self::once())
            ->method('isRoot')
            ->willReturn(true);
        $form
            ->expects(self::never())
            ->method('addError');

        $event = $this->createMock(FormEvent::class);
        $event
            ->method('getForm')
            ->willReturn($form);
        $event
            ->expects(self::once())
            ->method('getData')
            ->willReturn([
                self::HASH_FIELD => 'd41d8cd98f00b204e9800998ecf8427e'
            ]);

        (new HashValidationEventSubscriber(
            $request,
            $this->createMock(LoggerInterface::class),
            self::HASH_FIELD
        ))->preSubmit($event);
    }
}
