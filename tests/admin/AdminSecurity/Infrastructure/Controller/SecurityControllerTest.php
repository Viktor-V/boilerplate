<?php

declare(strict_types=1);

namespace App\Tests\Admin\AdminSecurity\Infrastructure\Controller;

use App\Admin\AdminDashboard\Infrastructure\Controller\DashboardController;
use App\Admin\AdminSecurity\Infrastructure\Controller\LogoutController;
use App\Admin\AdminSecurity\Infrastructure\Controller\SecurityController;
use App\Common\Home\Infrastructure\Controller\HomeController;
use App\Tests\AdminWebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = self::createClient();

        // Login to admin side
        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(SecurityController::AUTH_ROUTE_NAME)
        );
        $client->submit(
            $crawler->selectButton('Sign in')
                ->form(
                    [
                        'username' => AdminWebTestCase::ADMIN_USERNAME,
                        'password' => AdminWebTestCase::ADMIN_PASSWORD
                    ],
                    'POST'
                )
        );

        $client->followRedirect();
        self::assertEquals(
            DashboardController::DASHBOARD_ROUTE_NAME,
            $client->getRequest()->get('_route')
        );

        // Redirect back to dashboard
        $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(SecurityController::AUTH_ROUTE_NAME)
        );
        $client->followRedirect();
        self::assertEquals(
            DashboardController::DASHBOARD_ROUTE_NAME,
            $client->getRequest()->get('_route')
        );

        // Logout
        $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(LogoutController::LOGOUT_ROUTE_NAME)
        );
        $client->followRedirect(); // redirect to nolocale
        $client->followRedirect(); // redirect to homepage
        self::assertEquals(
            HomeController::HOME_ROUTE_NAME,
            $client->getRequest()->get('_route')
        );

        // Try to access admin side without login
        $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(DashboardController::DASHBOARD_ROUTE_NAME)
        );
        $client->followRedirect();
        self::assertEquals(
            SecurityController::AUTH_ROUTE_NAME,
            $client->getRequest()->get('_route')
        );

        // Try to login with wrong credentials
        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(SecurityController::AUTH_ROUTE_NAME)
        );
        $client->submit(
            $crawler->selectButton('Sign in')
                ->form(
                    [
                        'username' => AdminWebTestCase::ADMIN_USERNAME,
                        'password' => 'wrongpass'
                    ],
                    'POST'
                )
        );

        $client->followRedirect();
        self::assertSelectorTextContains('.alert', 'Invalid credentials');
    }
}
