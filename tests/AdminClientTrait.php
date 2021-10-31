<?php

declare(strict_types=1);

namespace App\Tests;

use App\Admin\AdminSecurity\Infrastructure\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait AdminClientTrait
{
    public function setupClient(): KernelBrowser
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
                        'username' => AdminConstant::ADMIN_USERNAME,
                        'password' => AdminConstant::ADMIN_PASSWORD
                    ],
                    'POST'
                )
        );

        return $client;
    }
}
