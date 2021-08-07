<?php

declare(strict_types=1);

namespace App\AdminSecurity\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminSecurity\AdminSecurityRouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route(path: AdminSecurityRouteName::AUTH_PATH, name: AdminSecurityRouteName::AUTH, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('admin_security/auth.html.twig');
    }
}
