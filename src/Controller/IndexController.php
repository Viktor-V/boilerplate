<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Kernel;

class IndexController
{
    #[Route("/")]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'php' => PHP_VERSION,
            'symfony' => Kernel::VERSION,
            'env' => $_SERVER['APP_ENV'],
            'rand' => random_int(0, 100)
        ]);
    }
}
