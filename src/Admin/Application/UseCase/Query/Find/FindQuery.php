<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\Find;

use App\Admin\Domain\Entity\ValueObject\Uuid;
use App\Common\Application\Query\QueryInterface;

class FindQuery implements QueryInterface
{
    public readonly Uuid $uuid;

    public function __construct(
        string $uuid
    ) {
        $this->uuid = new Uuid($uuid);
    }
}
