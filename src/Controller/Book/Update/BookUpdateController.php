<?php

declare(strict_types=1);

namespace App\Controller\Book\Update;

use App\Entity\Book;
use App\Form\FormType\Book\Update\UpdateBookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/books/{id}/update', name: 'app_book_update', methods: 'GET')]
final class BookUpdateController extends AbstractController
{
    public function __invoke(Book $book): Response
    {
        return $this->render(
            view: 'book/update/update.html.twig',
            parameters: [
                'book_form' => $this->createForm(type: UpdateBookType::class, data: $book),
                'book' => $book,
            ]
        );
    }
}
