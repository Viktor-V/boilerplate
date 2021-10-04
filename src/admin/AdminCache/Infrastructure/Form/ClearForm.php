<?php

declare(strict_types=1);

namespace App\Admin\AdminCache\Infrastructure\Form;

use App\Admin\AdminCache\Infrastructure\Controller\ClearController;
use App\Core\Admin\Infrastructure\Form\AbstractForm;
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
        $builder->setAction($this->urlGenerator->generate(ClearController::CACHE_CLEAR_ROUTE_NAME));
        $builder->setMethod('post');
    }
}
