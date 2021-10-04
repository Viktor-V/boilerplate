<?php

declare(strict_types=1);

namespace App\Admin\AdminSecurity\Infrastructure\Controller;

use App\Core\Admin\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogoutController extends AbstractController
{
    public const LOGOUT_ROUTE_NAME = self::ADMIN_CORE_NAME . 'logout';
    public const LOGOUT_ROUTE_PATH = 'logout';

    #[Route(path: self::LOGOUT_ROUTE_PATH, name: self::LOGOUT_ROUTE_NAME, methods: ['GET'])]
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
