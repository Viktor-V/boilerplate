<?php

declare(strict_types=1);

namespace App\Common\AntiSpam\Service\Contract;

use App\Common\AntiSpam\Exception\HiddenCaptchaException;

interface HiddenCaptchaValidatorInterface
{
    /**
     * @throws HiddenCaptchaException
     */
    public function valid(string $token): bool;
}
