<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Controller;

use App\Contact\Adapter\ContactHandler;
use App\Contact\RouteName;
use App\Contact\Infrastructure\Form\ContactForm;
use App\Contact\ValueObject\ContactRequestData;
use App\Core\Validator\ValidatorException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function __construct(
        private ContactHandler $handler,
        private LoggerInterface $logger
    ) {
    }

    #[Route(path: 'contact', name: RouteName::CONTACT, methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $contactRequest = new ContactRequestData();

        $form = $this->createForm(ContactForm::class, $contactRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handler->handle($contactRequest);

                $successMessage = _('We received your email and will respond as soon as possible.');

                $this->addFlash('success', $successMessage);

                return $this->redirectToRoute(RouteName::CONTACT);
            } catch (ValidatorException $exception) {
                $this->addFlash('danger', $exception->getMessage());
            } catch (TransportExceptionInterface $exception) {
                $this->logger->error('System cannot send email. Reason: ' . $exception->getMessage());

                $errorMessage = _('For some reason email cannot be sent. Please, try again later.');

                $this->addFlash('danger', $errorMessage);
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
