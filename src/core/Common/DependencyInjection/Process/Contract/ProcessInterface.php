<?php

declare(strict_types=1);

namespace App\Core\Common\DependencyInjection\Process\Contract;

use App\Core\Common\ValueObject\Contract\ProcessObjectInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Generator;

interface ProcessInterface
{
    /**
     * @param Generator<ProcessObjectInterface> $generator
     */
    public function execute(ContainerBuilder $container, Generator $generator): void;
}
