<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\Assert;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        Assert::assertEquals(200, $client->getResponse()->getStatusCode());

        $response = json_decode((string) $client->getResponse()->getContent());

        Assert::assertEquals(PHP_VERSION, $response->php);
        Assert::assertTrue(version_compare($response->symfony, '5.2.0', '>='));
    }
}
