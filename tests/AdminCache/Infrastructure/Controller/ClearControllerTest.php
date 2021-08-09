<?php

declare(strict_types=1);

namespace App\Tests\AdminCache\Infrastructure\Controller;

use App\AdminCache\AdminCacheRouteName;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClearControllerTest extends WebTestCase
{
    public function testClear(): void
    {
        $client = static::createClient(server: [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ]);

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(AdminCacheRouteName::CACHE)
        );
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        $client->submit($crawler->selectButton('Clear')->form(method: 'POST'));

        if ($client->getResponse()->getStatusCode() === 302) {
            $client->followRedirect();
        }

        self::assertStringContainsString(
            'Cache successfully cleared.',
            (string) $client->getResponse()->getContent()
        );
    }
}