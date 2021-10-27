<?php

declare(strict_types=1);

namespace App\Tests\Common\AntiSpam\Infrastructure\EventListener;

use App\Common\AntiSpam\Infrastructure\EventListener\CrawlerValidationEventSubscriber;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CrawlerValidationEventSubscriberTest extends TestCase
{
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

        $crawlerDetect = $this->createMock(CrawlerDetect::class);
        $crawlerDetect
            ->expects(self::never())
            ->method('isCrawler');

        (new CrawlerValidationEventSubscriber(
            $crawlerDetect,
            $request,
            $this->createMock(LoggerInterface::class)
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

        $crawlerDetect = $this->createMock(CrawlerDetect::class);
        $crawlerDetect
            ->expects(self::once())
            ->method('isCrawler')
            ->willReturn(true);

        (new CrawlerValidationEventSubscriber(
            $crawlerDetect,
            $request,
            $this->createMock(LoggerInterface::class)
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

        $crawlerDetect = $this->createMock(CrawlerDetect::class);
        $crawlerDetect
            ->expects(self::once())
            ->method('isCrawler')
            ->willReturn(false);

        (new CrawlerValidationEventSubscriber(
            $crawlerDetect,
            $request,
            $this->createMock(LoggerInterface::class)
        ))->preSubmit($event);
    }
}
