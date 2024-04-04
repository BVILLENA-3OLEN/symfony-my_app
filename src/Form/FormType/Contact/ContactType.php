<?php

declare(strict_types=1);

namespace App\Form\FormType\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                ]
            )
            ->add(
                child: 'email',
                type: EmailType::class,
                options: [
                    'label' => 'app.forms.contact.email.label',
                ]
            )
            ->add(
                child: 'appointmentDate',
                type: DateType::class,
                options: [
                    'label' => 'app.forms.contact.appointmentDate.label',
                ]
            )
            ->add(
                child: 'message',
                type: TextareaType::class,
                options: [
                    'label' => 'app.forms.contact.message.label',
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
                option: 'translation_domain',
                value: 'forms'
            );
    }
}
