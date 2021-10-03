<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection\Process\Contract;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Generator;

interface ProcessInterface
{
    /**
     * @param Generator<ProcessObjectInterface> $generator
     */
    public function execute(ContainerBuilder $container, Generator $generator): void;
}
