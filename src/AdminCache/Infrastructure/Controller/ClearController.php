<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Controller;

use App\AdminCache\AdminCacheRouteName;
use App\AdminCore\Service\ExecuteCommand;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClearController extends AbstractController
{
    public function __construct(
        private ExecuteCommand $executeCommand,
        private string $environment
    ) {
    }

    #[Route(path: AdminCacheRouteName::CACHE_CLEAR_PATH, name: AdminCacheRouteName::CACHE_CLEAR, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $cacheCleared = $this->executeCommand->execute(
            'cache:clear',
            ['--env' => $this->environment, '--no-debug' => true, '--quiet' => true]
        );

        $cacheCleared
            ? $this->addFlash('success', _('Cache successfully cleared.'))
            : $this->addFlash('danger', _('System error. Cache cannot be cleared.'));

        return $this->redirectToRoute(AdminCacheRouteName::CACHE);
    }
}