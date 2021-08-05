<?php

declare(strict_types=1);

namespace App\Tests\AdminCache\Infrastructure\Controller;

use App\AdminCache\AdminCacheRouteName;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WarmControllerTest extends WebTestCase
{
    public function testWarm(): void
    {
        $client = static::createClient();

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(AdminCacheRouteName::CACHE)
        );
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        $client->submit($crawler->selectButton('Warm')->form(method: 'POST'));
        $client->followRedirect();

        self::assertStringContainsString(
            'Cache successfully warmed.',
            (string) $client->getResponse()->getContent()
        );
    }
}
