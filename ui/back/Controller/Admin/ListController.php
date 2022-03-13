<?php

declare(strict_types=1);

namespace UI\Back\Controller\Admin;

use App\Admin\Application\UseCase\Query\List\ListQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Back\Request\Admin\ListPayload;
use UI\Common\Controller\AbstractController;

class ListController extends AbstractController
{
    #[Route('/admin/list', name: 'admin.list')]
    public function __invoke(ListPayload $payload): Response
    {
        //$this->addFlash();

        return $this->render('admin/list.html.twig', [
            'pagination' => $this->paginate(new ListQuery($payload->getPage(), $payload->getLimit(), $payload->getLikeEmail()))
        ]);
    }
}
