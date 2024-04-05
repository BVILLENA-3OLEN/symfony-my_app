<?php

declare(strict_types=1);

namespace App\Form\FormType\Contact;

use App\Model\Form\Contact\ContactModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

final class ContactType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(
                child: 'name',
                type: TextType::class,
                options: [
                    'label' => 'app.forms.contact.name.label',
                    'constraints' => [
                        new NotBlank(),
                        new Length(min: 10, max: 50),
                        new Regex(
                            pattern: '/\w+ \w+/',
                            message: 'Nom + Prénom svp'
                        )
                    ],
                ]
            )
            ->add(
                child: 'email',
                type: EmailType::class,
                options: [
                    'label' => 'app.forms.contact.email.label',
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                    ],
                ]
            )
            ->add(
                child: 'appointmentDate',
                type: DateType::class,
                options: [
                    'label' => 'app.forms.contact.appointmentDate.label',
                    'constraints' => [
                        new NotNull(),
                        new GreaterThan(value: 'today'),
                    ]
                ]
            )
            ->add(
                child: 'message',
                type: TextareaType::class,
                options: [
                    'label' => 'app.forms.contact.message.label',
                    'constraints' => [
                        new NotBlank(),
                        new Length(min: 5, max: 500),
                    ]
                ]
            )
            ->add(
                child: 'submit',
                type: SubmitType::class,
                options: [
                    'label' => 'app.forms.contact.submit.label',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault(
                option: 'data_class',
                value: ContactModel::class
            )
            ->setDefault(
                option: 'translation_domain',
                value: 'forms'
            );
    }
}
