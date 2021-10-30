<?php

declare(strict_types=1);

namespace App\Tests;

use App\Admin\AdminSecurity\Infrastructure\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminWebTestCase extends WebTestCase
{
    public const ADMIN_USERNAME = 'admin';
    public const ADMIN_PASSWORD = 'password';

    protected KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();

        // Login to admin side
        $crawler = $this->client->request(
            'GET',
            $this->client->getContainer()->get('router')->generate(SecurityController::AUTH_ROUTE_NAME)
        );
        $this->client->submit(
            $crawler->selectButton('Sign in')
                ->form(
                    [
                        'username' => self::ADMIN_USERNAME,
                        'password' => self::ADMIN_PASSWORD
                    ],
                    'POST'
                )
        );
    }
}
