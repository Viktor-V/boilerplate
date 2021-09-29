<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Compiler;

use App\Core\DependencyInjection\Compiler\CompilerPassTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class LanguageCompilerPass implements CompilerPassInterface
{
    use CompilerPassTrait;
}
