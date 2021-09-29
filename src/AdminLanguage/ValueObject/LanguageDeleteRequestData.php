<?php

declare(strict_types=1);

namespace App\AdminLanguage\ValueObject;

use App\Core\ValueObject\Contract\RequestDataInterface;

final class LanguageDeleteRequestData implements RequestDataInterface
{
    public string|null $identifier = null;
}
