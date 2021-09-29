<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminLanguage\Adapter\LanguageDeleteHandler;
use App\AdminLanguage\AdminLanguageRouteName;
use App\AdminLanguage\Infrastructure\Form\LanguageDeleteForm;
use App\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageDeleteController extends AbstractController
{
    public function __construct(
        private LanguageDeleteHandler $handler
    ) {
    }

    #[Route(path: AdminLanguageRouteName::LANGUAGE_PATH, name: AdminLanguageRouteName::LANGUAGE_DELETE, methods: ['DELETE'])]
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

        return $this->redirectToRoute(AdminLanguageRouteName::LANGUAGE);
    }
}
