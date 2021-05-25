<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\CrawlerValidationEventSubscriber;
use App\AntiSpam\Infrastructure\EventListener\HiddenValidationEventSubscriber;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormTypeCrawlerExtension implements FormTypeExtensionInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private LoggerInterface $logger
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }

        if ($options['crawler_protection'] === false) {
            return;
        }

        $builder
            ->addEventSubscriber(new CrawlerValidationEventSubscriber(
                new CrawlerDetect($request->server->all(), $request->headers->get('User-Agent')),
                $request,
                $this->logger
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'crawler_protection' => true
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
