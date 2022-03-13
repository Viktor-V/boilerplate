<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\List;

use App\Common\Application\Query\QueryInterface;
use App\Common\Domain\ValueObject\Query\Like;
use App\Common\Domain\ValueObject\Query\Limit;
use App\Common\Domain\ValueObject\Query\Offset;

class ListQuery implements QueryInterface
{
    public readonly Offset $offset;
    public readonly Limit $limit;
    public readonly Like $likeEmail;

    public function __construct(
        int $page,
        int $limit,
        ?string $likeEmail = null
    ) {
        $this->offset = new Offset($page);
        $this->limit = new Limit($limit);
        $this->likeEmail = new Like($likeEmail);
    }
}
