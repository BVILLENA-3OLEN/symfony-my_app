<?php

declare(strict_types=1);

namespace App\Controller\Book\Update;

use App\Entity\Book;
use App\Enum\Entity\Role\RoleEnum;
use App\Enum\Form\Options\CrudActionEnum;
use App\Form\FormType\Book\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/books/{id}/update', name: 'app_book_update_post', methods: 'POST')]
#[IsGranted(attribute: RoleEnum::ROLE_ADMIN->value)]
final class BookUpdatePostController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request, Book $book): Response
    {
        $bookForm = $this->createForm(
            type: BookType::class,
            data: $book,
            options: [
                'crud_action' => CrudActionEnum::UPDATE,
            ]
        );

        $bookForm->handleRequest($request);
        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute(route: 'app_book_list');
        }

        return $this->render(
            view: 'book/update/update.html.twig',
            parameters: [
                'book_form' => $bookForm,
                'book' => $book,
            ]
        );
    }
}
