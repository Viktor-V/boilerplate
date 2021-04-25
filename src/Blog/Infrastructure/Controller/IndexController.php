<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Controller;

use App\Blog\RouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route(path: 'blog', name: RouteName::BLOG, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('blog/index.html.twig');
    }
}
