<?php

declare(strict_types=1);

namespace App\Tests;

use App\BaseKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertEquals(200, $client->getResponse()->getStatusCode());

        self::assertSelectorTextContains('li:nth-child(1)', PHP_VERSION);
        self::assertSelectorTextContains('li:nth-child(2)', BaseKernel::VERSION);
        self::assertSelectorTextContains('li:nth-child(3)', $_SERVER['APP_ENV']);
    }
}
