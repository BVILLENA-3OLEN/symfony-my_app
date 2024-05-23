<?php

declare(strict_types=1);

namespace App\Controller\Book\Create;

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

#[Route(path: '/books/create', name: 'app_book_create_post', methods: 'POST')]
#[IsGranted(attribute: RoleEnum::ROLE_ADMIN->value)]
final class BookCreatePostController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $newBook = new Book();
        $bookForm = $this->createForm(
            type: BookType::class,
            data: $newBook,
            options: [
                'crud_action' => CrudActionEnum::CREATE,
            ]
        );

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
