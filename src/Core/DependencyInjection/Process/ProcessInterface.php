<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection\Process;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ProcessInterface
{
    public function execute(ContainerBuilder $container, array $data): void;
}
