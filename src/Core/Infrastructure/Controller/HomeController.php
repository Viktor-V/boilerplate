<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use App\BaseKernel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public const HOME_ROUTE_NAME = 'homepage';

    #[Route(path: null, name: self::HOME_ROUTE_NAME, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('core/home.html.twig', [
            'php' => PHP_VERSION,
            'symfony' => BaseKernel::VERSION,
            'env' => $_SERVER['APP_ENV']
        ]);
    }
}
