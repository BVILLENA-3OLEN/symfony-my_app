<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\Entity\Role\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $manager->persist((new User())
            ->setEmail('admin.3olen@lyon.ort.asso.fr')
            ->setPassword(
                password: $this->passwordHasherFactory
                    ->getPasswordHasher(User::class)
                    ->hash('admin')
            )
            ->addRole(
                role: $this->getReference(name: RoleEnum::ROLE_ADMIN->value, class: Role::class)
            )
            ->setIsVerified(true)
        );

        $fakerFactory = Factory::create(locale: 'fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $manager->persist(
                (new User())
                    ->setEmail($fakerFactory->email())
                    ->setPassword(
                        password: $this->passwordHasherFactory
                            ->getPasswordHasher(User::class)
                            ->hash('user')
                    )
                    ->setIsVerified(true)
            );
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
        ];
    }
}
