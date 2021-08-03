<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Form;

use App\AdminCache\AdminCacheRouteName;
use App\AdminCore\Infrastructure\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ClearForm extends AbstractForm
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->setAction($this->urlGenerator->generate(AdminCacheRouteName::CACHE_CLEAR));
        $builder->setMethod('post');
    }
}
