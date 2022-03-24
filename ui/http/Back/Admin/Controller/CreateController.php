<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Controller;

use App\Admin\Domain\Exception\EmailAlreadyExistException;
use Ramsey\Uuid\Uuid;
use App\Admin\Application\UseCase\Command\Create\CreateCommand;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Back\Admin\Request\CreatePayload;
use UI\Http\Common\Controller\AbstractController;
use Throwable;

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
            } catch (EmailAlreadyExistException $e) {
                $this->addFlash('error', $e->getMessage()); // TODO add trans;
            } catch (Throwable $e) {
                $this->getLogger()->error($e->getMessage());

                $this->addFlash('error', 'Something went wrong. Please, try latter.'); // TODO add trans;
            }
        }

        return $this->render('back/admin/create.html.twig', ['form' => $form->createView()]);
    }
}
