<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Event\AdminCreated;

use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Common\Domain\Event\EventHandlerInterface;
use Psr\Log\LoggerInterface;

class LogEventHandler implements EventHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(AdminCreatedEvent $event): void
    {
        $this->logger->info(sprintf('Admin Created! Email: %s; Uuid: %s', $event->getEmail(), $event->getUuid()));
    }
}
