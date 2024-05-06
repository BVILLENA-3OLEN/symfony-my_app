<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create(locale: 'fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $manager->persist(
                (new Book())
                    ->setIsbn($fakerFactory->isbn13())
                    ->setName(
                        rtrim(string: $fakerFactory->realTextBetween(minNbChars: 5, maxNbChars: 40), characters: '.')
                    )
                    ->setDescription($fakerFactory->realText())
                    ->setPublishedAt($fakerFactory->dateTimeBetween(startDate: '-20 years', endDate: '-6 months'))
                    ->setCopyCount($fakerFactory->numberBetween(int1: 0, int2: 10))
                    ->setAuthor($this->getAuthorReference(index: $i))
            );
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
        ];
    }

    private function getAuthorReference(int $index): Author
    {
        return $this->getReference(
            name: AuthorFixtures::getAuthorFixtureReferences()[
                array_key_exists($index, AuthorFixtures::getAuthorFixtureReferences())
                    ? $index
                    : array_rand(AuthorFixtures::getAuthorFixtureReferences())
            ],
            class: Author::class
        );
    }
}
