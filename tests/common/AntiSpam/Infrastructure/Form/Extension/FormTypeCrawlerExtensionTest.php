<?php

declare(strict_types=1);

namespace App\Tests\Common\AntiSpam\Infrastructure\Form\Extension;

use App\Common\AntiSpam\Infrastructure\EventListener\CrawlerValidationEventSubscriber;
use App\Common\AntiSpam\Infrastructure\Form\Extension\FormTypeCrawlerExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FormTypeCrawlerExtensionTest extends TestCase
{
    private const CRAWLER_PROTECT_ENABLED = true;

    public function testBuildForm(): void
    {
        $serverBag = $this->createMock(ServerBag::class);
        $serverBag
            ->method('all')
            ->willReturn([]);

        $headerBag = $this->createMock(HeaderBag::class);
        $headerBag
            ->method('get')
            ->with('User-Agent')
            ->willReturn(null);

        $request = $this->createMock(Request::class);
        $request->server = $serverBag;
        $request->headers = $headerBag;

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $logger = $this->createMock(LoggerInterface::class);

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects(self::once())
            ->method('addEventSubscriber')
            ->with(new CrawlerValidationEventSubscriber(
                new CrawlerDetect($request->server->all(), $request->headers->get('User-Agent')),
                $request,
                $logger
            ));

        (new FormTypeCrawlerExtension(
            $requestStack,
            $logger,
            self::CRAWLER_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'crawler_protection' => self::CRAWLER_PROTECT_ENABLED
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

        (new FormTypeCrawlerExtension(
            $requestStack,
            $logger,
            self::CRAWLER_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'crawler_protection' => self::CRAWLER_PROTECT_ENABLED
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

        (new FormTypeCrawlerExtension(
            $requestStack,
            $logger,
            self::CRAWLER_PROTECT_ENABLED
        ))->buildForm(
            $builder,
            [
                'crawler_protection' => false
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
                'crawler_protection' => self::CRAWLER_PROTECT_ENABLED
            ]);

        (new FormTypeCrawlerExtension(
            $this->createMock(RequestStack::class),
            $this->createMock(LoggerInterface::class),
            self::CRAWLER_PROTECT_ENABLED
        ))->configureOptions($resolver);
    }

    public function testGetExtendedTypes(): void
    {
        self::assertSame(
            [FormType::class],
            FormTypeCrawlerExtension::getExtendedTypes()
        );
    }
}
