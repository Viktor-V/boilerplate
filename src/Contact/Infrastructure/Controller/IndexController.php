<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Controller;

use App\Contact\RouteName;
use App\Contact\Infrastructure\Form\ContactForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route(path: 'contact', name: RouteName::CONTACT, methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $successMessage = _('Ok');

            $this->addFlash('success', $successMessage);

            return $this->redirectToRoute(RouteName::CONTACT);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
