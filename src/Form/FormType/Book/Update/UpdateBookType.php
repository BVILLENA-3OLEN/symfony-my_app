<?php

declare(strict_types=1);

namespace App\Form\FormType\Book\Update;

use App\Entity\Author;
use App\Entity\Book;
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

final class UpdateBookType extends AbstractType
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
                    'label' => 'app.forms.book.update.isbn.label',
                    'disabled' => true,
                ]
            )
            ->add(
                child: 'name',
                type: TextType::class,
                options: [
                    'label' => 'app.forms.book.update.name.label',
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
                    'choice_label' => static fn (Author $author): string => $author->getName(),
                    'label' => 'app.forms.book.update.author.label',
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                child: 'description',
                type: TextareaType::class,
                options: [
                    'label' => 'app.forms.book.update.description.label',
                ],
            )
            ->add(
                child: 'publishedAt',
                type: DateType::class,
                options: [
                    'widget' => 'single_text',
                    'label' => 'app.forms.book.update.publishedAt.label',
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
                    'label' => 'app.forms.book.update.copyCount.label',
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
                    'label' => 'app.forms.book.update.submit.label',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault(option: 'data_class', value: Book::class)
            ->setDefault(option: 'translation_domain', value: 'forms');
    }
}
