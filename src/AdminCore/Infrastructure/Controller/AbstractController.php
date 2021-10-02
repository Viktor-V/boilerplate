<?php

declare(strict_types=1);

namespace App\AdminCore\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;

abstract class AbstractController extends SymfonyController
{
    public const ADMIN_CORE_NAME = 'admin';
    public const ADMIN_CORE_PATH = 'admin';
}
