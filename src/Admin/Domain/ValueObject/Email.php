<?php

declare(strict_types=1);

namespace App\Admin\Domain\ValueObject;

use App\Common\Domain\Assert\Assertion;

final class Email
{
    private string $email;

    public function __construct(
        string $email
    ) {
        Assertion::notEmpty($email, 'Email should not be empty.');
        Assertion::email($email);

        $this->email = $email;
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
