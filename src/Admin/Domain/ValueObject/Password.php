<?php

declare(strict_types=1);

namespace App\Admin\Domain\ValueObject;

use App\Common\Domain\Assert\Assertion;

final class Password
{
    private string $password;

    public function __construct(
        string $password
    ) {
        Assertion::notEmpty($password);

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
