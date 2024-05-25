<?php

declare(strict_types=1);

namespace App\Controller\Book\Delete;

use App\Entity\Book;
use App\Enum\Voter\Book\BookAttributeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/books/{id}/delete', name: 'app_book_delete')]
final class BookDeleteController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(Book $book): Response
    {
        $this->denyAccessUnlessGranted(
            attribute: BookAttributeEnum::CAN_DELETE_BOOK->name,
            subject: $book
        );

        // Suppression physique
//        $this->entityManager->remove($book);

        // Suppression logique
        $book->setDeleted(true);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'Livre supprimé avec succès !'
        );

        return $this->redirectToRoute('app_book_list');
    }
}
