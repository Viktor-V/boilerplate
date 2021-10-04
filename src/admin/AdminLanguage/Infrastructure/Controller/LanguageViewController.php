<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Infrastructure\Controller;

use App\Admin\AdminLanguage\Adapter\LanguageCreateHandler;
use App\Admin\AdminLanguage\Domain\Language\LanguageFetcher;
use App\Admin\AdminLanguage\Infrastructure\Form\LanguageDeleteForm;
use App\Admin\AdminLanguage\ValueObject\LanguageCreateRequestData;
use App\Admin\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Admin\Infrastructure\Controller\AbstractController;
use App\Admin\AdminLanguage\Infrastructure\Form\LanguageCreateForm;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageViewController extends AbstractController
{
    public const LANGUAGE_ROUTE_NAME = self::ADMIN_CORE_NAME . 'language';
    public const LANGUAGE_ROUTE_PATH = 'language';

    public function __construct(
        private LanguageCreateHandler $handler,
        private LanguageFetcher $languageFetcher
    ) {
    }

    #[Route(
        path: self::LANGUAGE_ROUTE_PATH,
        name: self::LANGUAGE_ROUTE_NAME,
        methods: ['GET', 'POST']
    )]
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

                return $this->redirectToRoute(LanguageViewController::LANGUAGE_ROUTE_NAME);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            } catch (NonUniqueResultException | NoResultException) {
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
