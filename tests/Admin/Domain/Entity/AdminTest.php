<?php

declare(strict_types=1);

namespace App\Tests\Admin\Domain\Entity;

use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\ValueObject\Email;
use App\Admin\Domain\ValueObject\PlainPassword;
use App\Common\Domain\ValueObject\UuidInterface;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function testCreate(): void
    {
        $uuid = new class() implements UuidInterface {};

        $admin = Admin::create($uuid, new Email(), new PlainPassword());

        $events = [];
        foreach($admin->popEvents() as $event) {
            $events[] = $event::class;
        }

        self::assertContains(AdminCreatedEvent::class, $events);
    }
}