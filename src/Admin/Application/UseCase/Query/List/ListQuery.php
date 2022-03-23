<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\List;

use App\Common\Application\Query\QueryInterface;
use App\Common\Domain\ValueObject\Query\Like;
use App\Common\Domain\ValueObject\Query\Limit;
use App\Common\Domain\ValueObject\Query\Offset;
use DateTime;

class ListQuery implements QueryInterface
{
    public readonly Offset $offset;
    public readonly Limit $limit;
    public readonly ?Like $likeEmail;
    public readonly ?DateTime $startCreatedAt;
    public readonly ?DateTime $endCreatedAt;

    public function __construct(
        int $page,
        int $limit,
        ?string $likeEmail = null,
        ?string $startCreatedAt = null,
        ?string $endCreatedAt = null
    ) {
        $this->offset = new Offset($page);
        $this->limit = new Limit($limit);
        $this->likeEmail = $likeEmail ? new Like($likeEmail) : null;
        $this->startCreatedAt = $startCreatedAt ? new DateTime($startCreatedAt) : null;
        $this->endCreatedAt = $endCreatedAt ? new DateTime($endCreatedAt) : null;
    }
}
