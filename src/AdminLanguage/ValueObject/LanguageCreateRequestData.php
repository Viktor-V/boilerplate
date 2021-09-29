<?php

declare(strict_types=1);

namespace App\AdminLanguage\ValueObject;

use App\Core\ValueObject\Contract\RequestDataInterface;

final class LanguageCreateRequestData implements RequestDataInterface
{
    public string|null $code = null;
    public string|null $name = null;
    public string|null $native = null;
}
