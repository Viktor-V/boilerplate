<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AntiSpam\Infrastructure\Form\Extension\FormTypeAttemptExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeCrawlerExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHashExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenCaptchaExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenExtension;
use App\AntiSpam\Infrastructure\Form\Type\HiddenCaptchaType;
use App\AntiSpam\Service\HCaptchaValidator;
use App\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use App\AntiSpam\Service\ReCaptchaValidator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'form_themes' => [
            'anti_spam/form/hidden_field.html.twig',
            'anti_spam/form/hidden_captcha.html.twig'
        ]
    ]);

    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AntiSpam\\', __DIR__ . '/../../src/AntiSpam/')
        ->exclude(__DIR__ . '/../../src/AntiSpam/Infrastructure/{EventListener}');

    $services
        ->set(FormTypeHiddenExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeCrawlerExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeHashExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeAttemptExtension::class)
        ->arg('$cache', service('core.cache.default'))
        ->arg('$enabled', true)
        ->arg('$attemptCount', 10)
        ->arg('$attemptLastTime', 600);


    /* Available recaptcha and hcaptcha */
    $hiddenCaptchaType = 'recaptcha';

    $hiddenCaptchaExtension = $services->set(FormTypeHiddenCaptchaExtension::class);
    $hiddenCaptchaExtension
        ->arg('$enabled', true);
    switch ($hiddenCaptchaType) {
        case 'recaptcha':
            $services->set(HiddenCaptchaValidatorInterface::class, ReCaptchaValidator::class)
                ->arg('$privateKey', (string) param('anti_spam.hidden_captcha.private_key'));
            break;
        case 'hcaptcha':
            $services->set(HiddenCaptchaValidatorInterface::class, HCaptchaValidator::class)
                ->arg('$privateKey', (string) param('anti_spam.hidden_captcha.private_key'));
            break;
    }
    $hiddenCaptchaExtension->arg('$hiddenCaptchaValidator', service(HiddenCaptchaValidatorInterface::class));

    $services->set(HiddenCaptchaType::class)
        ->arg('$publicKey', (string) param('anti_spam.hidden_captcha.public_key'))
        ->arg('$type', $hiddenCaptchaType);

    $services->set(ReCaptchaValidator::class)
        ->arg('$privateKey', (string) param('anti_spam.hidden_captcha.private_key'));

    $services->set(HCaptchaValidator::class)
        ->arg('$privateKey', (string) param('anti_spam.hidden_captcha.private_key'));

    $parameters = $containerConfigurator->parameters();

    // Config values
    $parameters->set(
        'anti_spam.hidden_captcha.public_key',
        (string) param('env(resolve:ANTI_SPAM_HIDDEN_CAPTCHA_PUBLIC_KEY)')
    );
    $parameters->set(
        'anti_spam.hidden_captcha.private_key',
        (string) param('env(resolve:ANTI_SPAM_HIDDEN_CAPTCHA_PRIVATE_KEY)')
    );

    // Default environment values
    $parameters->set('env(ANTI_SPAM_HIDDEN_CAPTCHA_PUBLIC_KEY)', 'hidden_captcha_public_key');
    $parameters->set('env(ANTI_SPAM_HIDDEN_CAPTCHA_PRIVATE_KEY)', 'hidden_captcha_private_key');
};
