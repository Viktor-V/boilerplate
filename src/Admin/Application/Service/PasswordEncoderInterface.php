<?php

declare(strict_types=1);

namespace App\Admin\Application\Service;

use App\Admin\Domain\Entity\ValueObject\Password;
use App\Admin\Domain\Entity\ValueObject\PlainPassword;

interface PasswordEncoderInterface
{
    public function encode(PlainPassword $password): Password;
}
