<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Controller;

use App\Admin\Application\UseCase\Query\List\ListQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Back\Admin\Request\ListPayload;
use UI\Http\Common\Controller\AbstractController;

class ListController extends AbstractController
{
    #[Route('/admin/list', name: 'admin.list')]
    public function __invoke(ListPayload $payload): Response
    {
        return $this->render('back/admin/list.html.twig', [
            'pagination' => $this->paginate(new ListQuery(
                $payload->page,
                $payload->limit,
                $payload->sort,
                $payload->direction,
                $payload->likeEmail,
                $payload->startCreatedAt,
                $payload->endCreatedAt
            ))
        ]);
    }
}
