<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\HiddenValidationEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormTypeHiddenExtension implements FormTypeExtensionInterface
{
    private const FIELD_NAME = 'hidden';

    public function __construct(
        private RequestStack $requestStack,
        private LoggerInterface $logger
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getMasterRequest();
        if ($request !== null) {
            $builder
                ->addEventSubscriber(new HiddenValidationEventSubscriber(
                    $request,
                    $this->logger,
                    self::FIELD_NAME
                ));
        }
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if (!$view->parent) {
            $factory = $form->getConfig()->getFormFactory();

            $form = $factory->createNamed(self::FIELD_NAME, TextType::class, [], [
                'mapped' => false,
                'label' => false,
                'attr' => ['style' => 'display: none;']
            ]);

            $view->children[self::FIELD_NAME . '_field_name'] = $form->createView($view);
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        /* Empty */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        /* Empty */
    }
}
