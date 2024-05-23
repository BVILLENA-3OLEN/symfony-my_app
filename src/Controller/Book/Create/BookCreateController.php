<?php

declare(strict_types=1);

namespace App\Controller\Book\Create;

use App\Enum\Entity\Role\RoleEnum;
use App\Enum\Form\Options\CrudActionEnum;
use App\Form\FormType\Book\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/books/create', name: 'app_book_create', methods: 'GET')]
#[IsGranted(attribute: RoleEnum::ROLE_ADMIN->value)]
final class BookCreateController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'book/create/create.html.twig',
            parameters: [
                'book_form' => $this->createForm(
                    type: BookType::class,
                    options: [
                        'crud_action' => CrudActionEnum::CREATE,
                    ]
                ),
            ]
        );
    }
}
