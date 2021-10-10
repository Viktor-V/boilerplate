<?php

declare(strict_types=1);

namespace App\Common\Contact\Infrastructure\Form\RequestObject;

use App\Core\Common\ValueObject\Contract\RequestObjectInterface;

final class ContactRequestData implements RequestObjectInterface
{
    public string|null $name = null;
    public string|null $email = null;
    public string|null $subject = null;
    public string|null $message = null;
}
