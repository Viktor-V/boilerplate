<?php

declare(strict_types=1);

namespace App\Tests\Admin\Domain\Entity;

use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\Specification\UniqueEmailInterface;
use App\Admin\Domain\ValueObject\Email;
use App\Admin\Domain\ValueObject\Password;
use App\Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function testCreate(): void
    {
        $admin = Admin::create(
            new Uuid('b48b643e-a9b8-41a6-802d-0b438b566f62'),
            new Email('admin@admin.com'),
            new Password('qwert'),
            $this->createMock(UniqueEmailInterface::class)
        );

        self::assertInstanceOf(Admin::class, $admin);

        $events = [];
        foreach ($admin->popEvents() as $event) {
            $events[] = $event::class;
        }

        self::assertContains(AdminCreatedEvent::class, $events);
    }
}
