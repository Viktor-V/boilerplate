<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\Form\Extension;

use App\AntiSpam\Infrastructure\EventListener\HiddenFieldValidationEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psr\Log\LoggerInterface;

class FormTypeHiddenFieldExtension implements FormTypeExtensionInterface
{
    private const FIELD_NAME = 'hidden_field';

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

        if ($options['hidden_field_protection'] === false) {
            return;
        }

        $builder
            ->addEventSubscriber(new HiddenFieldValidationEventSubscriber(
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

        if ($options['hidden_field_protection'] === false) {
            return;
        }

        if ($view->parent === null) {
            $factory = $form->getConfig()->getFormFactory();

            $form = $factory->createNamed(self::FIELD_NAME, HiddenType::class, [], [
                'mapped' => false,
                'label' => false,
                'block_prefix' => self::FIELD_NAME
            ]);

            $view->children[self::FIELD_NAME . '_field_name'] = $form->createView($view);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'hidden_field_protection' => $this->enabled
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
