<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use App\BaseKernel;
use App\Core\RouteName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    #[Route(path: '/', name: RouteName::HOMEPAGE)]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['php' => PHP_VERSION, 'symfony' => BaseKernel::VERSION, 'env' => $_SERVER['APP_ENV']]);
    }
}
