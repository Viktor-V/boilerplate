<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Service;

use App\AntiSpam\Exception\HiddenCaptchaException;
use App\AntiSpam\Service\ReCaptchaValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;

class ReCaptchaValidatorTest extends TestCase
{
    private const URL = 'https://google.com/recaptcha/api/siteverify';

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
            ->willReturn(['success' => true, 'score' => 1.0]);

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
            (new ReCaptchaValidator($client, $privateKey))->valid($token)
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
            ->willReturn(['success' => false, 'score' => 0.4]);

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
            (new ReCaptchaValidator($client, $privateKey))->valid($token)
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

        (new ReCaptchaValidator($client, $privateKey))->valid($token);
    }
}
