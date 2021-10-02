<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminLanguage\Adapter\LanguagePrimeHandler;
use App\AdminLanguage\Infrastructure\Form\LanguagePrimeForm;
use App\AdminLanguage\ValueObject\LanguagePrimeRequestData;
use App\Core\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguagePrimeController extends AbstractController
{
    public const LANGUAGE_PRIME_ROUTE_NAME = LanguageViewController::LANGUAGE_ROUTE_NAME . 'prime';
    public const LANGUAGE_PRIME_ROUTE_PATH = LanguageViewController::LANGUAGE_ROUTE_PATH . '/prime';

    public function __construct(
        private LanguagePrimeHandler $handler
    ) {
    }

    #[Route(
        path: self::LANGUAGE_PRIME_ROUTE_PATH,
        name: self::LANGUAGE_PRIME_ROUTE_NAME,
        methods: ['PUT']
    )]
    public function __invoke(Request $request): Response
    {
        $form = $this
            ->createForm(LanguagePrimeForm::class, $languageRequest = new LanguagePrimeRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($languageRequest);

                $this->addFlash('success', _a('Language successfully set as prime!'));
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->redirectToRoute(
            LanguageEditController::LANGUAGE_EDIT_ROUTE_NAME,
            [
                'identifier' => $languageRequest->identifier
            ]
        );
    }
}
