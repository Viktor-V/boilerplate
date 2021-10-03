<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Form;

use App\Core\Admin\Infrastructure\Form\AbstractForm;
use App\AdminLanguage\Infrastructure\Controller\LanguageDeleteController;
use App\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LanguageDeleteForm extends AbstractForm
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->setAction($this->urlGenerator->generate(LanguageDeleteController::LANGUAGE_DELETE_ROUTE_NAME));
        $builder->setMethod('delete');

        $builder->add('identifier', HiddenType::class, [
            'label' => _a('Identifier'),
            'required' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', LanguageDeleteRequestData::class);
    }
}
