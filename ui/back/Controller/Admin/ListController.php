<?php

declare(strict_types=1);

namespace UI\Back\Controller\Admin;

use App\Admin\Application\UseCase\Query\All\AllQuery;
use App\Common\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Generator;

class ListController extends AbstractController
{
    public function __construct(
        private QueryBusInterface $bus
    ) {
    }

    #[Route('/admin/', name: 'admin.list')]
    public function __invoke(): Response
    {
        /** @var Generator $adminGenerator */
        $adminGenerator = $this->bus->handle(new AllQuery());

        $admins = [];
        foreach ($adminGenerator as $admin) {
            $admins[] = $admin;
        }
        
        return $this->render('admin/list.html.twig', ['admins' => $admins]);
    }
}
