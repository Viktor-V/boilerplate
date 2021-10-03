<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Common\AntiSpam\Infrastructure\Form\Type\HiddenCaptchaType;
use PHPUnit\Framework\TestCase;

class HiddenCaptchaTypeTest extends TestCase
{
    public function testBuildView(): void
    {
        $view = new FormView();

        (new HiddenCaptchaType('recaptcha', 'publicKey123'))
            ->buildView(
                $view,
                $this->createMock(FormInterface::class),
                []
            );

        self::assertSame([
            'captcha_type' => 'recaptcha',
            'public_key' => 'publicKey123',
            'value' => null,
            'attr' => [],
        ], $view->vars);
    }

    public function testConfigureOptions(): void
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver
            ->expects(self::once())
            ->method('setDefaults')
            ->with([]);

        (new HiddenCaptchaType('invalidcaptcha', 'publicKey123'))
            ->configureOptions($resolver);
    }

    public function testGetBlockPrefix(): void
    {
        self::assertSame(
            'hidden_captcha',
            (new HiddenCaptchaType('invalidcaptcha', 'publicKey123'))
                ->getBlockPrefix()
        );
    }

    public function testGetParent(): void
    {
        self::assertSame(
            HiddenType::class,
            (new HiddenCaptchaType('invalidcaptcha', 'publicKey123'))
                ->getParent()
        );
    }
}
