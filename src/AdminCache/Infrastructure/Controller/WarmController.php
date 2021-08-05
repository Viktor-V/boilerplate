<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Controller;

use App\AdminCache\AdminCacheRouteName;
use App\AdminCore\Service\CommandExecutor;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WarmController extends AbstractController
{
    public function __construct(
        private CommandExecutor $commandExecutor,
        private string $environment
    ) {
    }

    #[Route(path: AdminCacheRouteName::CACHE_WARM_PATH, name: AdminCacheRouteName::CACHE_WARM, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $cacheCleared = $this->commandExecutor->execute(
            'cache:warmup',
            ['--env' => $this->environment, '--no-debug' => true, '--quiet' => true]
        );

        $cacheCleared
            ? $this->addFlash('success', _('Cache successfully warmed.'))
            : $this->addFlash('danger', _('System error. Cache cannot be warmed.'));

        return $this->redirectToRoute(AdminCacheRouteName::CACHE);
    }
}
