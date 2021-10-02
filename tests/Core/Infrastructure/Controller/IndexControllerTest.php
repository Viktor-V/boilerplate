<?php

declare(strict_types=1);

namespace App\Tests\Core\Infrastructure\Controller;

use App\BaseKernel;
use App\Core\Infrastructure\Controller\HomeController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', $client->getContainer()->get('router')->generate(HomeController::HOME_ROUTE_NAME));

        self::assertEquals(200, $client->getResponse()->getStatusCode());

        self::assertSelectorTextContains('#php', PHP_VERSION);
        self::assertSelectorTextContains('#symfony', BaseKernel::VERSION);
        self::assertSelectorTextContains('#env', $_SERVER['APP_ENV']);
    }
}
