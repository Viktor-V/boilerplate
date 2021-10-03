<?php

declare(strict_types=1);

namespace App\Common\AntiSpam\Service;

use App\Common\AntiSpam\Exception\HiddenCaptchaException;
use App\Common\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HCaptchaValidator implements HiddenCaptchaValidatorInterface
{
    private const HCAPTCHA_URL = 'https://hcaptcha.com/siteverify';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $privateKey
    ) {
    }

    public function valid(string $token): bool
    {
        $response = $this->httpClient->request('POST', self::HCAPTCHA_URL, [
            'body' => [
                'secret' => $this->privateKey,
                'response' => $token
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new HiddenCaptchaException();
        }

        $response = $response->toArray();

        return $response['success'];
    }
}
