<?php

declare(strict_types=1);

namespace App\Tests\AntiSpam\Infrastructure\EventListener;

use PHPUnit\Framework\TestCase;

class HashValidationEventSubscriberTest extends TestCase
{
    public function testPreSubmit(): void
    {
        self::assertTrue(true);
    }
}
