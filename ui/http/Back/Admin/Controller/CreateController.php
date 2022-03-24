<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Controller;

use App\Admin\Domain\Exception\EmailAlreadyExistException;
use Ramsey\Uuid\Uuid;
use App\Admin\Application\UseCase\Command\Create\CreateCommand;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Back\Admin\Request\CreatePayload;
use UI\Http\Common\Controller\AbstractController;

class CreateController extends AbstractController
{
    #[Route('/admin/create', name: 'admin.create')]
    public function __invoke(CreatePayload $payload, FormInterface $form): Response
    {
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getCommandBus()->dispatch(new CreateCommand(
                    Uuid::uuid4()->toString(),
                    $payload->email,
                    $payload->password
                ));

                $this->addFlash('success', 'Admin successfully created.'); // TODO add trans

                return $this->redirectToRoute('backoffice.admin.list');
            } catch (HandlerFailedException $e) {
                $message = null;

                if ($e->getPrevious() instanceof EmailAlreadyExistException) {
                    $message = $e->getPrevious()->getMessage();
                }

                if ($message === null) {
                    $this->getLogger()->error($e->getMessage());
                }

                $this->addFlash('error', $message ?? 'Something went wrong. Please, try latter.');
            }
        }

        return $this->render('back/admin/create.html.twig', ['form' => $form->createView()]);
    }
}
