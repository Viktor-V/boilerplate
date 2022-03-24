<?php

declare(strict_types=1);

namespace UI\Http\Common\Controller;

use App\Common\Application\Command\CommandBusInterface;
use App\Common\Application\Query\QueryBusInterface;
use App\Common\Application\Query\QueryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use LogicException;
use Psr\Log\LoggerInterface;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function getCommandBus(): CommandBusInterface
    {
        return $this->container->get(CommandBusInterface::class);
    }

    public function getQueryBus(): QueryBusInterface
    {
        return $this->container->get(QueryBusInterface::class);
    }

    public function paginate(QueryInterface $query): PaginationInterface
    {
        if (property_exists($query, 'offset') && property_exists($query, 'limit')) {
            return $this->getPaginator()->paginate(
                $this->getQueryBus()->handle($query),
                $query->offset->toNumber() + 1,
                $query->limit->toNumber()
            );
        }

        throw new LogicException('You cannot use the Paginator without offset or limit.');
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->container->get(PaginatorInterface::class);
    }

    public function getLogger(): LoggerInterface
    {
        return $this->container->get(LoggerInterface::class);
    }

    public static function getSubscribedServices(): array
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                QueryBusInterface::class,
                CommandBusInterface::class,
                PaginatorInterface::class,
                LoggerInterface::class
            ]
        );
    }
}
