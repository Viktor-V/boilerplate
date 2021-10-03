<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Controller;

use App\Core\Admin\Service\CommandExecutor;
use App\Core\Admin\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClearController extends AbstractController
{
    public const CACHE_CLEAR_ROUTE_NAME = CacheController::CACHE_ROUTE_NAME . 'clear';
    public const CACHE_CLEAR_ROUTE_PATH = CacheController::CACHE_ROUTE_PATH . '/clear';

    public function __construct(
        private CommandExecutor $commandExecutor,
        private string $environment
    ) {
    }

    #[Route(path: self::CACHE_CLEAR_ROUTE_PATH, name: self::CACHE_CLEAR_ROUTE_NAME, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $cacheCleared = $this->commandExecutor->execute(
            'cache:clear',
            ['--env' => $this->environment, '--no-debug' => true, '--quiet' => true]
        );

        $cacheCleared
            ? $this->addFlash('success', _a('Cache successfully cleared.'))
            : $this->addFlash('danger', _a('System error. Cache cannot be cleared.'));

        return $this->redirectToRoute(CacheController::CACHE_ROUTE_NAME);
    }
}
