<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Service;

use App\AntiSpam\Exception\HiddenCaptchaException;
use App\AntiSpam\Service\HCaptchaValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;

class HCaptchaValidatorTest extends TestCase
{
    private const URL = 'https://hcaptcha.com/siteverify';

    public function testValidCaptcha(): void
    {
        $privateKey = 'privateKey';
        $token = 'token';

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn(200);
        $response
            ->method('toArray')
            ->willReturn(['success' => true]);

        $client = $this->createMock(HttpClientInterface::class);
        $client
            ->method('request')
            ->with(
                'POST',
                self::URL,
                [
                    'body' => ['secret' => $privateKey, 'response' => $token]
                ]
            )
            ->willReturn($response);

        self::assertTrue(
            (new HCaptchaValidator($client, $privateKey))->valid($token)
        );
    }

    public function testInvalidCaptcha(): void
    {
        $privateKey = 'privateKey';
        $token = 'token';

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn(200);
        $response
            ->method('toArray')
            ->willReturn(['success' => false]);

        $client = $this->createMock(HttpClientInterface::class);
        $client
            ->method('request')
            ->with(
                'POST',
                self::URL,
                [
                    'body' => ['secret' => $privateKey, 'response' => $token]
                ]
            )
            ->willReturn($response);

        self::assertFalse(
            (new HCaptchaValidator($client, $privateKey))->valid($token)
        );
    }

    public function testInvalidStatusCode(): void
    {
        $privateKey = 'privateKey';
        $token = 'token';

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn(500);

        $client = $this->createMock(HttpClientInterface::class);
        $client
            ->method('request')
            ->with(
                'POST',
                self::URL,
                [
                    'body' => ['secret' => $privateKey, 'response' => $token]
                ]
            )
            ->willReturn($response);

        $this->expectException(HiddenCaptchaException::class);

        (new HCaptchaValidator($client, $privateKey))->valid($token);
    }
}
