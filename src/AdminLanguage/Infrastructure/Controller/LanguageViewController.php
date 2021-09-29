<?php

declare(strict_types=1);

namespace App\AdminLanguage\Infrastructure\Controller;

use App\AdminLanguage\Adapter\LanguageCreateHandler;
use App\AdminLanguage\Domain\Language\LanguageFetcher;
use App\AdminLanguage\Infrastructure\Form\LanguageDeleteForm;
use App\AdminLanguage\ValueObject\LanguageCreateRequestData;
use App\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Validator\Exception\ValidatorException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminLanguage\Infrastructure\Form\LanguageCreateForm;
use App\AdminLanguage\AdminLanguageRouteName;

class LanguageViewController extends AbstractController
{
    public function __construct(
        private LanguageCreateHandler $handler,
        private LanguageFetcher $languageFetcher
    ) {
    }

    #[Route(path: AdminLanguageRouteName::LANGUAGE_PATH, name: AdminLanguageRouteName::LANGUAGE, methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this
            ->createForm(LanguageCreateForm::class, $languageRequest = new LanguageCreateRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($languageRequest);

                $this->addFlash(
                    'success',
                    _a('New language successfully added. Do not forget to add translations for the new language!')
                );

                return $this->redirectToRoute(AdminLanguageRouteName::LANGUAGE);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            } catch (NonUniqueResultException|NoResultException) {
                $this->addFlash(
                    'danger',
                    _a('For some reason new language cannot be added. Please, try again later.')
                );
            }
        }

        return $this->render('admin_language/language.html.twig', [
            'createForm' => $form,
            'deleteForm' => $this->createForm(LanguageDeleteForm::class, new LanguageDeleteRequestData()),
            'data' => $this->languageFetcher->all()
        ]);
    }
}
