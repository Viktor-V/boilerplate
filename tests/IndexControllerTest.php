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

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('li:nth-child(1)', PHP_VERSION);
        $this->assertSelectorTextContains('li:nth-child(2)', BaseKernel::VERSION);
        $this->assertSelectorTextContains('li:nth-child(3)', $_SERVER['APP_ENV']);
    }
}
