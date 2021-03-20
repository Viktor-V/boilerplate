<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller;

use App\Core\Adapter\Service\ProjectInfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    public function __construct(
        private ProjectInfo $projectInfo
    ) {}

    #[Route("/")]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->projectInfo->info());
    }
}
