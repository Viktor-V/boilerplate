<?php

declare(strict_types=1);

namespace App\AdminDashboard\Infrastructure\Controller;

use App\AdminDashboard\AdminDashboardRouteName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route(path: AdminDashboardRouteName::AUTH_PATH, name: AdminDashboardRouteName::AUTH, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin/auth.html.twig');
    }
}
