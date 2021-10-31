<?php

declare(strict_types=1);

namespace App\Tests\Admin\AdminLanguage\Infrastructure\Controller;

use App\Admin\AdminLanguage\Infrastructure\Controller\LanguageViewController;
use App\Tests\AdminClientTrait;
use App\Tests\DoctrineTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LanguageViewControllerTest extends WebTestCase
{
    use DoctrineTrait;
    use AdminClientTrait;

    public function testView(): void
    {
        $client = $this->setupClient();

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(LanguageViewController::LANGUAGE_ROUTE_NAME)
        );

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertStringContainsString(
            'Please, add new languages.',
            (string) $client->getResponse()->getContent()
        );

        $client->submit(
            $crawler
                ->selectButton('Add')
                ->form(
                    [
                        'language_create_form[code]' => 'en'
                    ],
                    'POST'
                )
        );

        $client->followRedirect();

        self::assertSelectorTextContains('td > b', 'en');
        self::assertStringContainsString(
            'New language successfully added. Do not forget to add translations for the new language!',
            (string) $client->getResponse()->getContent()
        );
    }
}
