<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\HashValidationEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psr\Log\LoggerInterface;

class FormTypeHashExtension implements FormTypeExtensionInterface
{
    private const FIELD_NAME = 'hash';

    public function __construct(
        private RequestStack $requestStack,
        private LoggerInterface $logger,
        private bool $enabled
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }

        if ($options['hash_field_protection'] === false) {
            return;
        }

        $builder
            ->addEventSubscriber(new HashValidationEventSubscriber(
                $request,
                $this->logger,
                self::FIELD_NAME
            ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if ($view->parent) {
            return;
        }

        if ($options['hash_field_protection'] === false) {
            return;
        }

        if ($view->parent === null) {
            $factory = $form->getConfig()->getFormFactory();
            $hashField = $factory->createNamed(self::FIELD_NAME, HiddenType::class, [], [
                'mapped' => false,
                'attr' => [
                    'data-hash-form-target' => 'hash'
                ]
            ]);
            $view->children[self::FIELD_NAME . '_field_name'] = $hashField->createView($view);

            $view->vars['attr'] = array_merge(
                $view->vars['attr'],
                [
                    'data-controller' => 'hash-form',
                    'data-action' => 'hash-form#onSubmit'
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'hash_field_protection' => $this->enabled
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
}
