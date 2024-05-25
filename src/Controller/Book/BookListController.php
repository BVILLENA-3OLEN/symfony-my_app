<?php

declare(strict_types=1);

namespace App\Controller\Book;

use App\Enum\Entity\Role\RoleEnum;
use App\Enum\Voter\Book\BookAttributeEnum;
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
                'books' => $bookRepository->getList(),
                'can_create_book' => $this->isGranted(RoleEnum::ROLE_ADMIN->value),
                'can_update_book' => $this->isGranted(RoleEnum::ROLE_ADMIN->value),
                'can_delete_book_enum' => BookAttributeEnum::CAN_DELETE_BOOK,
                'can_remove_copy_book_enum' => BookAttributeEnum::CAN_REMOVE_COPY_BOOK,
            ]
        );
    }
}
