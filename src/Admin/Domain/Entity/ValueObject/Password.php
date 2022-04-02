<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity\ValueObject;

use App\Common\Domain\Assert\Assertion;

final class Password
{
    private string $password;

    public function __construct(
        string $password
    ) {
        Assertion::notEmpty($password, 'Password should not be empty.');

        $this->password = $password;
    }

    public function toString(): string
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
