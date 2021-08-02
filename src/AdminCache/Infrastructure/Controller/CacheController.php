<?php

declare(strict_types=1);

namespace App\AdminCache\Infrastructure\Controller;

use App\AdminCache\AdminCacheRouteName;
use App\AdminCache\Infrastructure\Form\ClearForm;
use App\AdminCache\Infrastructure\Form\WarmForm;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController
{
    #[Route(path: AdminCacheRouteName::CACHE_PATH, name: AdminCacheRouteName::CACHE, methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->render(
            'admin_cache/cache.html.twig',
            [
                'clearForm' => $this->createForm(ClearForm::class)->handleRequest($request),
                'warmForm' => $this->createForm(WarmForm::class)->handleRequest($request)
            ]
        );
    }
}
