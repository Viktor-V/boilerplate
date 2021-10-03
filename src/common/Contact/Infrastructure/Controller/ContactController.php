<?php

declare(strict_types=1);

namespace App\Common\Contact\Infrastructure\Controller;

use App\Common\Contact\Adapter\ContactHandler;
use App\Common\Contact\Infrastructure\Form\ContactForm;
use App\Common\Contact\ValueObject\ContactRequestData;
use App\Core\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    public const CONTACT_ROUTE_NAME = 'contact';
    public const CONTACT_ROUTE_PATH = 'contact';

    public function __construct(
        private ContactHandler $handler,
        private string $supportEmail,
        private string $supportPhone
    ) {
    }

    #[Route(path: self::CONTACT_ROUTE_PATH, name: self::CONTACT_ROUTE_NAME, methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this
            ->createForm(ContactForm::class, $contactRequest = new ContactRequestData())
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($contactRequest);

                $successMessage = _('We received your email and will respond as soon as possible.');

                $this->addFlash('success', $successMessage);

                return $this->redirectToRoute(self::CONTACT_ROUTE_NAME);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            } catch (TransportExceptionInterface) {
                $this->addFlash('danger', _('For some reason email cannot be sent. Please, try again later.'));
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
            'supportEmail' => $this->supportEmail,
            'supportPhone' => $this->supportPhone,
        ]);
    }
}
