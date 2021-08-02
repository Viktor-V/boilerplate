<?php

declare(strict_types=1);

namespace App\AdminCore\Service;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

class ExecuteCommand
{
    public function __construct(
        private KernelInterface $kernel,
        private LoggerInterface $logger
    ) {
    }

    public function execute(string $command, array $options = []): bool
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array_merge(['command' => $command], $options));
        $output = new BufferedOutput();

        try {
            $result = $application->run($input, $output);
        } catch (Throwable $e) {
            $this->logger->error('Cannot execute command. Reason: ' . $e->getMessage());

            return false;
        }

        $this->logger->info($output->fetch());

        return $result === 0;
    }

}