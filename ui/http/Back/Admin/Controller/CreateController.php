<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Controller;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Back\Admin\Request\CreatePayload;
use UI\Http\Common\Controller\AbstractController;

class CreateController extends AbstractController
{
    #[Route('/admin/create', name: 'admin.create')]
    public function __invoke(CreatePayload $payload, FormInterface $form): Response
    {
        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('back/admin/create.html.twig', ['form' => $form->createView()]);
    }
}
