<?php

declare(strict_types=1);

namespace App\AntiSpam\Service;

use App\AntiSpam\Exception\HiddenCaptchaException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ReCaptchaValidator implements HiddenCaptchaValidatorInterface
{
    private const RECAPTCHA_THRESHOLD = 0.5;
    private const RECAPTCHA_URL = 'https://google.com/recaptcha/api/siteverify';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $privateKey
    ) {
    }

    public function valid(string $token): bool
    {
        $response = $this->httpClient->request('POST', self::RECAPTCHA_URL, [
            'body' => [
                'secret' => $this->privateKey,
                'response' => $token
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new HiddenCaptchaException();
        }

        $response = $response->toArray();

        return $response['success'] && $response['score'] >= self::RECAPTCHA_THRESHOLD;
     }
}