<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminLanguage\AdminLanguageRouteName;
use App\Core\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageUpdateController extends AbstractController
{
    /*public function __construct(
        private LanguageHandler $handler
    ) {
    }

    #[Route(path: AdminLanguageRouteName::LANGUAGE_PATH, name: AdminLanguageRouteName::LANGUAGE, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this
            ->createForm(LanguageCreateForm::class, $languageRequest = new LanguageCreateRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($languageRequest);

                $this->addFlash('success', _a('New language successfully added.'));
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->redirectToRoute(AdminLanguageRouteName::LANGUAGE);
    }*/
}
