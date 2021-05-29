<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\AttemptValidationEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Log\LoggerInterface;

class FormTypeAttemptExtension implements FormTypeExtensionInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private CacheInterface $cache,
        private LoggerInterface $logger,
        private int $attemptCount,
        private int $attemptLastTime,
        private bool $enabled
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }

        if ($options['attempt_protection'] === false) {
            return;
        }

        $builder
            ->addEventSubscriber(new AttemptValidationEventSubscriber(
                $request,
                $this->cache,
                $this->logger,
                $options['attempt_count'],
                $options['attempt_last_time']
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attempt_protection' => $this->enabled,
            'attempt_count' => $this->attemptCount,
            'attempt_last_time' => $this->attemptLastTime
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        /* Empty */
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        /* Empty */
    }
}
