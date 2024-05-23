<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Role;
use App\Enum\Entity\Role\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adminRole = (new Role())
            ->setCode(RoleEnum::ROLE_ADMIN)
            ->setLabel('Administrateur');
        $this->setReference(name: RoleEnum::ROLE_ADMIN->value, object: $adminRole);
        $manager->persist($adminRole);

        $manager->flush();
    }
}
