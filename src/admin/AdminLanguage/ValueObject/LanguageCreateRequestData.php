<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\ValueObject;

use App\Core\Common\ValueObject\Contract\RequestDataInterface;

final class LanguageCreateRequestData implements RequestDataInterface
{
    public string $code;
    public string $name;
    public string $native;
}
