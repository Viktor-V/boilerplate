<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Controller;

use App\Blog\BlogRouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route(path: 'blog', name: BlogRouteName::BLOG, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('blog/index.html.twig');
    }
}
