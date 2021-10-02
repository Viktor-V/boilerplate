<?php

declare(strict_types=1);

namespace App\Tests\Contact\Infrastructure\Controller;

use App\Contact\Infrastructure\Controller\ContactController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Messenger\Transport\InMemoryTransport;
use Symfony\Component\Mime\Email;

class ContactControllerTest extends WebTestCase
{
    /**
     * @return string[][][]
     */
    public function provider(): array
    {
        return [
            'Submit form with correct values' => [
                [
                    'contact_form[name]' => 'Firstname L.',
                    'contact_form[email]' => 'email@example.com',
                    'contact_form[subject]' => 'This is test subject',
                    'contact_form[message]' => 'This is test message'
                ]
            ],
            'Submit form with invalid email' => [
                [
                    'contact_form[name]' => 'Firstname L.',
                    'contact_form[email]' => 'email.com',
                    'contact_form[subject]' => 'This is test subject',
                    'contact_form[message]' => 'This is test message'
                ]
            ]
        ];
    }

    /**
     * @param string[][][] $formData
     *
     * @dataProvider provider
     */
    public function testContactForm(array $formData): void
    {
        $client = self::createClient();

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate(ContactController::CONTACT_ROUTE_NAME)
        );
        $client->submit($crawler->selectButton('Send Message')->form($formData, 'POST'));

        // Form contain invalid data
        if ($client->getResponse()->getStatusCode() !== 302) {
            self::assertStringContainsString('Email is not valid.', (string) $client->getResponse()->getContent());

            return;
        }

        /** @var InMemoryTransport $transport */
        $transport = static::getContainer()->get('messenger.transport.async');

        $messages = $transport->getSent();
        self::assertCount(2, $messages);

        /** @var SendEmailMessage $transportMessage */
        $transportMessage = $messages[0]->getMessage();
        /** @var Email $email */
        $email = $transportMessage->getMessage();
        self::assertEquals('This is test subject', $email->getSubject());
        self::assertEquals('This is test message', $email->getTextBody());

        /** @var SendEmailMessage $transportMessage */
        $transportMessage = $messages[1]->getMessage();
        /** @var TemplatedEmail $email */
        $email = $transportMessage->getMessage();
        self::assertEquals('Request received', $email->getSubject());

        $client->followRedirect();
        self::assertEquals(200, $client->getResponse()->getStatusCode());

        self::assertStringContainsString(
            'We received your email and will respond as soon as possible.',
            (string) $client->getResponse()->getContent()
        );
    }
}
