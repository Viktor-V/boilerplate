<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Controller;

use App\Admin\AdminRouteName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route(path: AdminRouteName::AUTH_PATH, name: AdminRouteName::AUTH, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin/auth.html.twig');
    }
}
