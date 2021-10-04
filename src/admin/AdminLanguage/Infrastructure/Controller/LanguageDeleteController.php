<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Infrastructure\Controller;

use App\Core\Admin\Infrastructure\Controller\AbstractController;
use App\Admin\AdminLanguage\Adapter\LanguageDeleteHandler;
use App\Admin\AdminLanguage\Infrastructure\Form\LanguageDeleteForm;
use App\Admin\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Common\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageDeleteController extends AbstractController
{
    public const LANGUAGE_DELETE_ROUTE_NAME = LanguageViewController::LANGUAGE_ROUTE_NAME . 'delete';
    public const LANGUAGE_DELETE_ROUTE_PATH = LanguageViewController::LANGUAGE_ROUTE_PATH . '/delete';

    public function __construct(
        private LanguageDeleteHandler $handler
    ) {
    }

    #[Route(
        path: self::LANGUAGE_DELETE_ROUTE_PATH,
        name: self::LANGUAGE_DELETE_ROUTE_NAME,
        methods: ['DELETE']
    )]
    public function __invoke(Request $request): Response
    {
        $form = $this
            ->createForm(LanguageDeleteForm::class, $languageRequest = new LanguageDeleteRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($languageRequest);

                $this->addFlash('success', _a('Language successfully deleted!'));
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->redirectToRoute(LanguageViewController::LANGUAGE_ROUTE_NAME);
    }
}
