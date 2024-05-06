<?php

declare(strict_types=1);

namespace App\Controller\Book\Create;

use App\Entity\Book;
use App\Form\FormType\Book\Create\CreateBookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/books/create', name: 'app_book_create_post', methods: 'POST')]
final class BookCreatePostController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $newBook = new Book();
        $bookForm = $this->createForm(type: CreateBookType::class, data: $newBook);

        $bookForm->handleRequest($request);
        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $this->entityManager->persist($newBook);
            $this->entityManager->flush();

            return $this->redirectToRoute(route: 'app_book_list');
        }

        return $this->render(
            view: 'book/create/create.html.twig',
            parameters: [
                'book_form' => $bookForm,
            ]
        );
    }
}
