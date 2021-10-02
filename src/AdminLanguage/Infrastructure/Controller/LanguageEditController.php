<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminLanguage\Adapter\LanguageEditHandler;
use App\AdminLanguage\AdminLanguageRouteName;
use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\AdminLanguage\Infrastructure\Form\LanguageEditForm;
use App\AdminLanguage\Infrastructure\Form\LanguagePrimeForm;
use App\AdminLanguage\ValueObject\LanguageEditRequestData;
use App\AdminLanguage\ValueObject\LanguagePrimeRequestData;
use App\Core\Validator\Exception\ValidatorException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageEditController extends AbstractController
{
    public function __construct(
        private LanguageEditHandler $handler
    ) {
    }

    #[Route(
        path: AdminLanguageRouteName::LANGUAGE_EDIT_PATH,
        name: AdminLanguageRouteName::LANGUAGE_EDIT,
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

                return $this->redirectToRoute(AdminLanguageRouteName::LANGUAGE_EDIT, [
                    'identifier' => $language->getIdentifier()
                ]);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('admin_language/language_edit.html.twig', [
            'editForm' => $editForm,
            'primeForm' => $this->createForm(LanguagePrimeForm::class, new LanguagePrimeRequestData()),
            'language' => $language
        ]);
    }
}
