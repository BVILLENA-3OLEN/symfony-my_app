<?php

declare(strict_types=1);

namespace App\Controller\Book\RemoveCopy;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/books/{id}/remove-copy', name: 'app_book_remove_copy')]
final class BookRemoveCopyController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(Book $book): Response
    {
        $this->denyAccessUnlessGranted(
            attribute: 'can_remove_copy_book',
            subject: $book
        );

        $book->setCopyCount($book->getCopyCount() - 1);
        $this->entityManager->flush();

        $this->addFlash(
            type: 'success',
            message: 'Exemplaire supprimé avec succès !'
        );

        return $this->redirectToRoute('app_book_list');
    }
}
