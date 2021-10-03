<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\EventListener;

use App\Common\AntiSpam\Exception\HiddenCaptchaException;
use App\Common\AntiSpam\Infrastructure\EventListener\HiddenCaptchaValidationEventSubscriber;
use App\Common\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class HiddenCaptchaValidationEventSubscriberTest extends TestCase
{
    private const HIDDEN_CAPTCHA_FIELD = 'hidden_captcha';

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

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $hiddenCaptchaValidator
            ->expects(self::never())
            ->method('valid');

        (new HiddenCaptchaValidationEventSubscriber(
            $request,
            $hiddenCaptchaValidator,
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_FIELD
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
                self::HIDDEN_CAPTCHA_FIELD => 'hiddencaptchatoken'
            ]);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $hiddenCaptchaValidator
            ->expects(self::once())
            ->method('valid')
            ->willReturn(false);

        (new HiddenCaptchaValidationEventSubscriber(
            $request,
            $hiddenCaptchaValidator,
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_FIELD
        ))->preSubmit($event);
    }

    public function testHiddenCaptchaValidatorThrowsException(): void
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
                self::HIDDEN_CAPTCHA_FIELD => 'hiddencaptchatoken'
            ]);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $hiddenCaptchaValidator
            ->expects(self::once())
            ->method('valid')
            ->willThrowException(new HiddenCaptchaException());

        (new HiddenCaptchaValidationEventSubscriber(
            $request,
            $hiddenCaptchaValidator,
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_FIELD
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
                self::HIDDEN_CAPTCHA_FIELD => 'hiddencaptchatoken'
            ]);

        $hiddenCaptchaValidator = $this->createMock(HiddenCaptchaValidatorInterface::class);
        $hiddenCaptchaValidator
            ->expects(self::once())
            ->method('valid')
            ->willReturn(true);

        (new HiddenCaptchaValidationEventSubscriber(
            $request,
            $hiddenCaptchaValidator,
            $this->createMock(LoggerInterface::class),
            self::HIDDEN_CAPTCHA_FIELD
        ))->preSubmit($event);
    }
}
