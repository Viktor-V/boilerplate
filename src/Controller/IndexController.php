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
        return new JsonResponse(['php' => phpversion(), 'symfony' => Kernel::VERSION]);
    }
}
