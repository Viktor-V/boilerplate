<?php

declare(strict_types=1);

use App\BaseKernel;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/../vendor/autoload.php';
(new Dotenv())->bootEnv(dirname(__DIR__) . '/../.env');

$kernel = new BaseKernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
