<?php

declare(strict_types=1);

namespace UI\Common\Controller;

use App\Common\Application\Query\QueryBusInterface;
use Knp\Component\Pager\PaginatorInterface;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function getQueryBus(): QueryBusInterface
    {
        return $this->container->get(QueryBusInterface::class);
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->container->get(PaginatorInterface::class);
    }
}
