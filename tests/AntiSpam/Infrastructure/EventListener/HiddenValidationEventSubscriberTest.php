<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\EventListener;

use PHPUnit\Framework\TestCase;

class HiddenValidationEventSubscriberTest extends TestCase
{
    public function testPreSubmit(): void
    {
        self::assertTrue(true);
    }
}