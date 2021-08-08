<?php

declare(strict_types=1);

namespace App\AdminSecurity\Infrastructure\Controller;

use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminSecurity\AdminSecurityRouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogoutController extends AbstractController
{
    #[Route(path: AdminSecurityRouteName::LOGOUT_PATH, name: AdminSecurityRouteName::LOGOUT, methods: ['GET'])]
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
