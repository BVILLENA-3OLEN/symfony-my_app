<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AuthorFixtures extends Fixture
{
    private static array $authorFixtureReferences = [];

    public static function getAuthorFixtureReferences(): array
    {
        return static::$authorFixtureReferences;
    }

    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create();
        for ($i = 0; $i < 20; ++$i) {
            $author = (new Author())
                ->setName("{$fakerFactory->firstName} {$fakerFactory->lastName()}");
            $this->defineReference(reference: $author);

            $manager->persist($author);
        }

        $manager->flush();
    }

    private function defineReference(Author $reference): void
    {
        $this->addReference(name: static::class . '#' . spl_object_id($reference), object: $reference);
        static::$authorFixtureReferences[] = static::class . '#' . spl_object_id($reference);
    }
}
