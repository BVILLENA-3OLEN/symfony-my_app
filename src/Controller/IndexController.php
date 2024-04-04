<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'app_index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __invoke(
        LoggerInterface $logger,
        #[MapQueryParameter(name: 'name')]
        ?string $name = null
    ): Response {
        $logger->info("J'ai reçu le query parameter {$name}.");

        return $this->render(
            view: 'index.html.twig',
            parameters: [
                'name' => $name,
            ]
        );
    }
}
