<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserFixtures extends Fixture
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
            ->setRoles(['ROLE_ADMIN'])
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
}
