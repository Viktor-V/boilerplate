<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Controller;

use App\Contact\Adapter\ContactHandler;
use App\Contact\RouteName;
use App\Contact\Infrastructure\Form\ContactForm;
use App\Contact\ValueObject\ContactRequestData;
use App\Core\Validator\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route(path: 'contact', name: RouteName::CONTACT, methods: ['GET', 'POST'])]
    public function __invoke(Request $request, ContactHandler $handler): Response
    {
        $contactRequest = new ContactRequestData();

        $form = $this->createForm(ContactForm::class, $contactRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($contactRequest);

                $successMessage = _('We received your email and respond as soon as possible.');

                $this->addFlash('success', $successMessage);

                return $this->redirectToRoute(RouteName::CONTACT);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
