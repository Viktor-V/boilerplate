<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\DependencyInjection\Compiler;

use App\Admin\AdminLanguage\DependencyInjection\Process\LanguageProcessObject;
use App\Core\Common\DependencyInjection\Compiler\CompilerPassTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Generator;

class LanguageCompilerPass implements CompilerPassInterface
{
    use CompilerPassTrait;

    /**
     * @param array<int,mixed> $data
     *
     * @return Generator<LanguageProcessObject>
     */
    protected function generateObjects(array $data): Generator
    {
        foreach ($data as $row) {
            yield LanguageProcessObject::initialize($row);
        }
    }
}