<?php

declare(strict_types=1);

namespace App\Tests\AdminCore\Service;

use App\Core\Admin\Service\CommandExecutor;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;
use Exception;

class CommandExecutorTest extends TestCase
{
    public function testSuccessfulExecute(): void
    {
        $application = $this->createMock(Application::class);
        $application
            ->method('setAutoExit')
            ->with(false);
        $application
            ->method('run')
            ->willReturn(0);

        $logger = $this->createMock(LoggerInterface::class);

        self::assertTrue(
            (new CommandExecutor($application, $logger))->execute('command')
        );
    }

    public function testFailedExecute(): void
    {
        $logger = $this->createMock(LoggerInterface::class);

        $application = $this->createMock(Application::class);
        $application
            ->method('setAutoExit')
            ->with(false);
        $application
            ->method('run')
            ->willReturn(1);

        self::assertFalse(
            (new CommandExecutor($application, $logger))->execute('command')
        );

        $application = $this->createMock(Application::class);
        $application
            ->method('setAutoExit')
            ->with(false);
        $application
            ->method('run')
            ->willThrowException(new Exception());

        self::assertFalse(
            (new CommandExecutor($application, $logger))->execute('command')
        );
    }
}
