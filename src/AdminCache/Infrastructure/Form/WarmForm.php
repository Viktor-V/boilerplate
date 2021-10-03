<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Form;

use App\AdminCache\Infrastructure\Controller\WarmController;
use App\Core\Admin\Infrastructure\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class WarmForm extends AbstractForm
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->setAction($this->urlGenerator->generate(WarmController::CACHE_WARM_ROUTE_NAME));
        $builder->setMethod('post');
    }
}
