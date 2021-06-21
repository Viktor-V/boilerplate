<?php

declare(strict_types=1);

namespace App\AntiSpam\Service;

use App\AntiSpam\Exception\HiddenCaptchaException;

interface HiddenCaptchaValidatorInterface
{
    /**
     * @throws HiddenCaptchaException
     */
    public function valid(string $token): bool;
}