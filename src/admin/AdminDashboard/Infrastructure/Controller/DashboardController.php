<?php

declare(strict_types=1);

namespace App\Admin\AdminDashboard\Infrastructure\Controller;

use App\BaseKernel;
use App\Core\Admin\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public const DASHBOARD_ROUTE_NAME = self::ADMIN_CORE_NAME . 'dashboard';
    public const DASHBOARD_ROUTE_PATH = null;

    #[Route(path: self::DASHBOARD_ROUTE_PATH, name: self::DASHBOARD_ROUTE_NAME, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin/admin_dashboard/dashboard.html.twig', [
            'php' => PHP_VERSION,
            'symfony' => BaseKernel::VERSION,
            'env' => $_SERVER['APP_ENV']
        ]);
    }
}
