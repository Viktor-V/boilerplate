<?php

declare(strict_types=1);

namespace UI\Back\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function __invoke(): Response
    {
        return $this->render('dashboard.html.twig');
    }
}
