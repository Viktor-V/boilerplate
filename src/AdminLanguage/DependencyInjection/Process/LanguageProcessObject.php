<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Process;

use App\Core\Common\DependencyInjection\Process\Contract\ProcessObjectInterface;
use App\Core\Common\Domain\View\FromArrayTrait;

class LanguageProcessObject implements ProcessObjectInterface
{
    use FromArrayTrait;

    public string|null $code = null;
    public string|null $name = null;
    public string|null $native = null;
    public bool $prime = false;
}
