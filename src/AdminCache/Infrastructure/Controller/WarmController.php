<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Controller;

use App\AdminCore\Service\CommandExecutor;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WarmController extends AbstractController
{
    public const CACHE_WARM_ROUTE_NAME = CacheController::CACHE_ROUTE_NAME . 'warm';
    public const CACHE_WARM_ROUTE_PATH = CacheController::CACHE_ROUTE_PATH . '/warm';

    public function __construct(
        private CommandExecutor $commandExecutor,
        private string $environment
    ) {
    }

    #[Route(path: self::CACHE_WARM_ROUTE_PATH, name: self::CACHE_WARM_ROUTE_NAME, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $cacheCleared = $this->commandExecutor->execute(
            'cache:warmup',
            ['--env' => $this->environment, '--no-debug' => true, '--quiet' => true]
        );

        $cacheCleared
            ? $this->addFlash('success', _a('Cache successfully warmed.'))
            : $this->addFlash('danger', _a('System error. Cache cannot be warmed.'));

        return $this->redirectToRoute(CacheController::CACHE_ROUTE_NAME);
    }
}
