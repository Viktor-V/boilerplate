<?php

declare(strict_types=1);

namespace App\AdminDashboard\Infrastructure\Controller;

use App\BaseKernel;
use App\AdminDashboard\AdminDashboardRouteName;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: AdminDashboardRouteName::DASHBOARD_PATH, name: AdminDashboardRouteName::DASHBOARD, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin_dashboard/dashboard.html.twig', [
            'php' => PHP_VERSION,
            'symfony' => BaseKernel::VERSION,
            'env' => $_SERVER['APP_ENV']
        ]);
    }
}
