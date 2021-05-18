<?php

declare(strict_types=1);

namespace App\ErrorPage\Infrastructure\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function show(FlattenException $exception, DebugLoggerInterface $logger = null): Response
    {
        return $this->render('error_page/error.html.twig', [
            'exception' => $exception,
            'statusCode' => $exception->getStatusCode(),
            'statusText' => $exception->getStatusText()
        ]);
    }
}
