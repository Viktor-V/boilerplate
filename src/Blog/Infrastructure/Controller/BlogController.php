<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public const BLOG_ROUTE_NAME = 'blog';
    public const BLOG_ROUTE_PATH = 'blog';

    #[Route(path: self::BLOG_ROUTE_PATH, name: self::BLOG_ROUTE_NAME, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('blog/index.html.twig');
    }
}
