<?php

declare(strict_types=1);

namespace App\Tests\AdminCache\Infrastructure\Controller;

use App\Admin\AdminCache\Infrastructure\Controller\CacheController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WarmControllerTest extends WebTestCase
{
    public function testWarm(): void
    {
        $client = static::createClient(server: [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ]);

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(CacheController::CACHE_ROUTE_NAME)
        );
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        $client->submit($crawler->selectButton('Warm')->form(method: 'POST'));

        if ($client->getResponse()->getStatusCode() === 302) {
            $client->followRedirect();
        }

        self::assertStringContainsString(
            'Cache successfully warmed.',
            (string) $client->getResponse()->getContent()
        );
    }
}
