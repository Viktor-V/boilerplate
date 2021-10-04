<?php

declare(strict_types=1);

namespace App\Admin\AdminCache\Infrastructure\Controller;

use App\Admin\AdminCache\Infrastructure\Form\ClearForm;
use App\Admin\AdminCache\Infrastructure\Form\WarmForm;
use App\Core\Admin\Infrastructure\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController
{
    public const CACHE_ROUTE_NAME = self::ADMIN_CORE_NAME . 'cache';
    public const CACHE_ROUTE_PATH = 'cache';

    #[Route(path: self::CACHE_ROUTE_PATH, name: self::CACHE_ROUTE_NAME, methods: ['GET'])]
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
