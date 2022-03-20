<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Controller;

use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Admin\Application\UseCase\Query\Find\FindQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Common\Controller\AbstractController;

class EditController extends AbstractController
{
    #[Route('/admin/edit/{uuid}', name: 'admin.edit')]
    public function __invoke(string $uuid): Response
    {
        $admin = $this->getQueryBus()->handle(new FindQuery($uuid));
        if (!$admin instanceof AdminDTO) {
            throw new NotFoundHttpException();
        }

        return $this->render('back/admin/edit.html.twig', ['admin' => $admin]);
    }
}
