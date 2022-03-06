<?php

declare(strict_types=1);

namespace UI\Back\Controller\Admin;

use App\Admin\Application\UseCase\Query\All\AllQuery;
use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Common\Application\Query\QueryBusInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Common\Controller\AbstractController;

class ListController extends AbstractController
{
    public function __construct(
        private QueryBusInterface $bus,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/admin/', name: 'admin.list')]
    public function __invoke(Request $request): Response
    {
        $query = new AllQuery(
            $request->query->getInt('page', AllQuery::DEFAULT_PAGE),
            $request->query->getInt('limit', AllQuery::DEFAULT_LIMIT)
        );

        /** @var AdminDTO[] $pagination */
        $pagination = $this->paginator->paginate($this->bus->handle($query), $query->page, $query->limit);

        return $this->render('admin/list.html.twig', ['pagination' => $pagination]);
    }
}
