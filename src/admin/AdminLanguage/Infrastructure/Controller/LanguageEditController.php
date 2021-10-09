<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Infrastructure\Controller;

use App\Core\Admin\Infrastructure\Controller\AbstractController;
use App\Admin\AdminLanguage\Adapter\LanguageEditHandler;
use App\Admin\AdminLanguage\AdminLanguageRouteName;
use App\Admin\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Admin\AdminLanguage\Infrastructure\Form\LanguageEditForm;
use App\Admin\AdminLanguage\Infrastructure\Form\LanguagePrimeForm;
use App\Admin\AdminLanguage\ValueObject\LanguageEditRequestData;
use App\Admin\AdminLanguage\ValueObject\LanguagePrimeRequestData;
use App\Core\Common\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageEditController extends AbstractController
{
    public const LANGUAGE_EDIT_ROUTE_NAME = LanguageViewController::LANGUAGE_ROUTE_NAME . 'edit';
    public const LANGUAGE_EDIT_ROUTE_PATH = LanguageViewController::LANGUAGE_ROUTE_PATH . '/{identifier}/edit';

    public function __construct(
        private LanguageEditHandler $handler
    ) {
    }

    #[Route(
        path: self::LANGUAGE_EDIT_ROUTE_PATH,
        name: self::LANGUAGE_EDIT_ROUTE_NAME,
        methods: ['GET', "PUT"]
    )]
    public function __invoke(LanguageEntity $language, Request $request): Response
    {
        $editForm = $this
            ->createForm(LanguageEditForm::class, $languageRequest = new LanguageEditRequestData($language))
            ->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $this->handler->handle($languageRequest);

                $this->addFlash('success', _a('Language successfully updated!'));

                return $this->redirectToRoute(self::LANGUAGE_EDIT_ROUTE_NAME, [
                    'identifier' => $language->getIdentifier()
                ]);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('admin/admin_language/language_edit.html.twig', [
            'editForm' => $editForm,
            'primeForm' => $this->createForm(LanguagePrimeForm::class, new LanguagePrimeRequestData()),
            'language' => $language
        ]);
    }
}
