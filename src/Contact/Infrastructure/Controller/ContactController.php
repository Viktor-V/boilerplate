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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route(path: RouteName::CONTACT_PATH, name: RouteName::CONTACT, methods: ['GET', 'POST'])]
    public function __invoke(Request $request, ContactHandler $handler): Response
    {
        $form = $this
            ->createForm(ContactForm::class, $contactRequest = new ContactRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($contactRequest);

                $successMessage = _('We received your email and will respond as soon as possible.');

                $this->addFlash('success', $successMessage);

                return $this->redirectToRoute(RouteName::CONTACT);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            } catch (TransportExceptionInterface) {
                $this->addFlash('danger', _('For some reason email cannot be sent. Please, try again later.'));
            }
        }

        return $this->render('contact/index.html.twig', ['form' => $form]);
    }
}
