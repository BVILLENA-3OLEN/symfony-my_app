<?php

declare(strict_types=1);

namespace App\Voter\Book;

use App\Entity\Book;
use App\Enum\Entity\Role\RoleEnum;
use App\Enum\Voter\Book\BookAttributeEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class RemoveCopyBookVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === BookAttributeEnum::CAN_REMOVE_COPY_BOOK->name;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return
            in_array(
                needle: RoleEnum::ROLE_ADMIN->value,
                haystack: $token->getUser()->getRoles()
            )
            && $subject instanceof Book
            && $subject->isDeleted() === false
            && $subject->getCopyCount() > 0;
    }
}
