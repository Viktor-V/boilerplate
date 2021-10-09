<?php

declare(strict_types=1);

namespace App\Common\ErrorPage\Infrastructure\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function __invoke(FlattenException $exception): Response
    {
        return $this->render('common/error_page/error.html.twig', [
            'exception' => $exception,
            'statusCode' => $exception->getStatusCode(),
            'statusText' => $exception->getStatusText()
        ]);
    }
}
