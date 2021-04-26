<?php

declare(strict_types=1);

namespace App\Contact\ValueObject;

use App\Core\ValueObject\Contract\RequestDataInterface;

final class ContactRequestData implements RequestDataInterface
{
    public string|null $name = null;
    public string|null $email = null;
    public string|null $subject = null;
    public string|null $message = null;
}
