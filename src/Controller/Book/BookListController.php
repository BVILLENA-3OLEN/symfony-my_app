<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/books', name: 'app_book_list', methods: 'GET')]
final class BookListController extends AbstractController
{
    public function __invoke(
        BookRepository $bookRepository,
    ): Response {
        return $this->render(
            view: 'book/list.html.twig',
            parameters: [
                'books' => $bookRepository->findAll(),
            ]
        );
    }
}
