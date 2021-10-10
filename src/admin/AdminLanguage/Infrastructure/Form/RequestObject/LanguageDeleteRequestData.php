<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Infrastructure\Form\RequestObject;

use App\Core\Common\ValueObject\Contract\RequestObjectInterface;

final class LanguageDeleteRequestData implements RequestObjectInterface
{
    public string $identifier;
}
