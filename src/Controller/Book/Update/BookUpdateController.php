<?php

declare(strict_types=1);

namespace App\Controller\Book\Update;

use App\Entity\Book;
use App\Enum\Entity\Role\RoleEnum;
use App\Enum\Form\Options\CrudActionEnum;
use App\Form\FormType\Book\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/books/{id}/update', name: 'app_book_update', methods: 'GET')]
#[IsGranted(attribute: RoleEnum::ROLE_ADMIN->value)]
final class BookUpdateController extends AbstractController
{
    public function __invoke(Book $book): Response
    {
        return $this->render(
            view: 'book/update/update.html.twig',
            parameters: [
                'book_form' => $this->createForm(
                    type: BookType::class,
                    data: $book,
                    options: [
                        'crud_action' => CrudActionEnum::UPDATE,
                    ]
                ),
                'book' => $book,
            ]
        );
    }
}
