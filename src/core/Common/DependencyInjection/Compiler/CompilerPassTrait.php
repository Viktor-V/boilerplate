<?php

declare(strict_types=1);

namespace App\Core\Common\DependencyInjection\Compiler;

use App\Core\Common\DependencyInjection\Process\Contract\ProcessObjectInterface;
use App\Core\Common\DependencyInjection\Query\Contract\QueryInterface;
use App\Core\Common\DependencyInjection\Process\Contract\ProcessInterface;
use App\Core\Common\DependencyInjection\Connection\ConnectionInitialization;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\DBAL\Exception;
use Generator;

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
        $connection = $this->connectionInitialization->connect();
        if ($connection === null) {
            return;
        }

        $data = $this->connectionQuery->fetch($connection);
        if (count($data) === 0) {
            return;
        }

        $this->process->execute($container, $this->generateObjects($data));
    }

    /**
     * @param array<int,mixed> $data
     *
     * @return Generator<ProcessObjectInterface>
     */
    abstract protected function generateObjects(array $data): Generator;
}
