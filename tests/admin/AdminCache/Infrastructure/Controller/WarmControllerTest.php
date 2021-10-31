<?php

declare(strict_types=1);

namespace App\Tests\Admin\AdminCache\Infrastructure\Controller;

use App\Admin\AdminCache\Infrastructure\Controller\CacheController;
use App\Tests\AdminClientTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WarmControllerTest extends WebTestCase
{
    use AdminClientTrait;

    public function testWarm(): void
    {
        $client = $this->setupClient();

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
