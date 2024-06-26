<?php

declare(strict_types=1);

namespace App\Form\FormType\Book;

use App\Entity\Author;
use App\Entity\Book;
use App\Enum\Form\Options\CrudActionEnum;
use App\Repository\AuthorRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Isbn;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

final class BookType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(
                child: 'isbn',
                type: TextType::class,
                options: [
                    'label' => 'app.forms.book.isbn.label',
                    'constraints' => [
                        new NotBlank(),
                        new Isbn(type: Isbn::ISBN_13),
                    ],
                    'disabled' => $options['crud_action'] === CrudActionEnum::UPDATE,
                ]
            )
            ->add(
                child: 'name',
                type: TextType::class,
                options: [
                    'label' => 'app.forms.book.name.label',
                    'constraints' => [
                        new NotBlank(),
                        new Length(max: 200),
                    ],
                ]
            )
            ->add(
                child: 'author',
                type: EntityType::class,
                options: [
                    'class' => Author::class,
                    'query_builder' => static fn (AuthorRepository $repository): QueryBuilder => (
                        $repository
                            ->createQueryBuilder('a')
                            ->orderBy('a.name')
                    ),
                    'choice_label' => static fn (Author $author): string => $author->getName(),
                    'label' => 'app.forms.book.author.label',
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                child: 'description',
                type: TextareaType::class,
                options: [
                    'label' => 'app.forms.book.description.label',
                ],
            )
            ->add(
                child: 'publishedAt',
                type: DateType::class,
                options: [
                    'widget' => 'single_text',
                    'label' => 'app.forms.book.publishedAt.label',
                    'constraints' => [
                        new NotNull(),
                        new LessThan(value: 'today'),
                    ],
                ],
            )
            ->add(
                child: 'copyCount',
                type: IntegerType::class,
                options: [
                    'label' => 'app.forms.book.copyCount.label',
                    'constraints' => [
                        new NotNull(),
                        new PositiveOrZero(),
                    ],
                ],
            )
            ->add(
                child: 'submit',
                type: SubmitType::class,
                options: [
                    'label' => 'app.forms.book.' . mb_strtolower($options['crud_action']->name) . '.submit.label',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault(option: 'data_class', value: Book::class)
            ->setDefault(option: 'translation_domain', value: 'forms');

        $resolver
            ->define('crud_action')
            ->required()
            ->allowedTypes(CrudActionEnum::class);
    }
}
