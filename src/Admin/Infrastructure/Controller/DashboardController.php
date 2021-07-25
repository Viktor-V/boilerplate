<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Controller;

use App\Admin\AdminRouteName;
use App\BaseKernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: AdminRouteName::ADMIN_PATH, name: AdminRouteName::ADMIN, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'php' => PHP_VERSION,
            'symfony' => BaseKernel::VERSION,
            'env' => $_SERVER['APP_ENV']
        ]);
    }
}