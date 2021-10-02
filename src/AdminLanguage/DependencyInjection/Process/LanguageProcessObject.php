<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Process;

use App\Core\DependencyInjection\Process\Contract\ProcessObjectInterface;
use App\Core\Domain\View\FromArrayTrait;

class LanguageProcessObject implements ProcessObjectInterface
{
    public string|null $code = null;
    public string|null $name = null;
    public string|null $native = null;
    public bool $prime = false;

    use FromArrayTrait;
}
