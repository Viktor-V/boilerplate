<?php

declare(strict_types=1);

namespace App\Admin\Domain\ValueObject;

use App\Common\Domain\Assert\Assertion;

final class PlainPassword
{
    public const MIN_PASSWORD_LENGTH = 5;

    private string $plainPassword;

    public function __construct(
        string $plainPassword
    ) {
        Assertion::notEmpty($plainPassword);
        Assertion::minLength($plainPassword, self::MIN_PASSWORD_LENGTH);

        $this->plainPassword = $plainPassword;
    }

    public function toString(): string
    {
        return $this->plainPassword;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}