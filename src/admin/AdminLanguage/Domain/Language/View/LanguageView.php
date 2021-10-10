<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Domain\Language\View;

use App\Core\Common\Domain\View\FromArrayTrait;
use App\Core\Common\ValueObject\Contract\ViewObjectInterface;

final class LanguageView implements ViewObjectInterface
{
    use FromArrayTrait;

    public string|null $identifier = null;
    public string|null $code = null;
    public string|null $name = null;
    public string|null $native = null;
    public bool $prime = false;
}
