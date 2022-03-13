<?php

declare(strict_types=1);

namespace UI\Back\Controller\Admin;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Back\Request\Admin\CreatePayload;
use UI\Common\Controller\AbstractController;

class CreateController extends AbstractController
{
    #[Route('/admin/create', name: 'admin.create')]
    public function __invoke(CreatePayload $payload, FormInterface $form): Response
    {
        if ($form->isSubmitted() && $form->isValid()) {
            dump('YAY');
        }

        return $this->render('admin/create.html.twig', ['form' => $form->createView()]);
    }
}
