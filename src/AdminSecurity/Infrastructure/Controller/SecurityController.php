<?php

declare(strict_types=1);

namespace App\AdminSecurity\Infrastructure\Controller;

use App\Core\Admin\Infrastructure\Controller\AbstractController;
use App\AdminDashboard\Infrastructure\Controller\DashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public const AUTH_ROUTE_NAME = self::ADMIN_CORE_NAME . 'auth';
    public const AUTH_ROUTE_PATH = 'auth';

    #[Route(path: self::AUTH_ROUTE_PATH, name: self::AUTH_ROUTE_NAME, methods: ['GET', 'POST'])]
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute(DashboardController::DASHBOARD_ROUTE_NAME);
        }

        return $this->render(
            'admin_security/auth.html.twig',
            ['error' => $authenticationUtils->getLastAuthenticationError()]
        );
    }
}
