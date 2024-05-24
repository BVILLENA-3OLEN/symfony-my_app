<?php

declare(strict_types=1);

namespace App\Voter\Book;

use App\Entity\Book;
use App\Enum\Entity\Role\RoleEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class DeleteBookVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'can_delete_book';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (
            in_array(
                needle: RoleEnum::ROLE_ADMIN->value,
                haystack: $token->getUser()->getRoles()
            )
        ) {
            return $subject instanceof Book
                && $subject->isDeleted() === false
                && $subject->getCopyCount() === 0;
        }

        return false;
    }
}
