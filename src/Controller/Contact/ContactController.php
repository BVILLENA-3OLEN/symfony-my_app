<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Form\FormType\Contact\ContactType;
use App\Model\Form\Contact\ContactModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/contact', name: 'app_contact', methods: 'GET')]
final class ContactController extends AbstractController
{
    public function __invoke(): Response
    {
        $contactModel = new ContactModel();
        $contactModel->setName('General Kenobi');
        $contactForm = $this->createForm(
            type: ContactType::class,
            data: $contactModel
        );

        return $this->render(
            view: 'contact/contact.html.twig',
            parameters: [
                'contact_form' => $contactForm->createView(),
            ]
        );
    }
}
