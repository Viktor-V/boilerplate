<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection\Compiler;

use App\Core\DependencyInjection\Query\QueryInterface;
use App\Core\DependencyInjection\Process\ProcessInterface;
use App\Core\DependencyInjection\Connection\ConnectionInitialization;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\DBAL\Exception;

trait CompilerPassTrait
{
    public function __construct(
        private ConnectionInitialization $connectionInitialization,
        private QueryInterface $connectionQuery,
        private ProcessInterface $process
    ) {
    }

    /**
     * @throws Exception
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$connection = $this->connectionInitialization->connect()) {
            return;
        }

        $data = $this->connectionQuery->fetch($connection);
        if (empty($data)) {
            return;
        }

        $this->process->execute($container, $data);
    }
}
