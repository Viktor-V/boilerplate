<?php

declare(strict_types=1);

namespace App\AdminCore\Service;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Psr\Log\LoggerInterface;
use Throwable;

final class CommandExecutor
{
    public function __construct(
        private Application $application,
        private LoggerInterface $logger
    ) {
    }

    public function execute(string $command, array $options = []): bool
    {
        $this->application->setAutoExit(false);

        $input = new ArrayInput(array_merge(['command' => $command], $options));
        $output = new BufferedOutput();

        try {
            $result = $this->application->run($input, $output);
        } catch (Throwable $e) {
            $this->logger->error('Cannot execute command. Reason: ' . $e->getMessage());

            return false;
        }

        $this->logger->info($output->fetch());

        return $result === 0;
    }
}
