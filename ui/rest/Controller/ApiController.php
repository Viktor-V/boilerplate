<?php

declare(strict_types=1);

namespace Ui\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController
{
    #[Route('/api', name: 'api')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['json' => true]);
    }
}
