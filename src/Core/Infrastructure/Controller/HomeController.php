<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use App\BaseKernel;
use App\Core\CoreRouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: null, name: CoreRouteName::HOMEPAGE, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('core/home.html.twig', [
            'php' => PHP_VERSION,
            'symfony' => BaseKernel::VERSION,
            'env' => $_SERVER['APP_ENV']
        ]);
    }
}