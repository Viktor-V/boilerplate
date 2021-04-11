<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Controller;

use App\Contact\RouteName;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route(path: '/contact', name: RouteName::CONTACT)]
    public function __invoke(): Response
    {
        return $this->render('contact/index.html.twig');
    }
}
