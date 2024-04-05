<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Form\FormType\Contact\ContactType;
use App\Model\Form\Contact\ContactModel;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/contact',
    name: 'app_contact_post',
    methods: 'POST'
)]
final class ContactPostController extends AbstractController
{
    public function __invoke(
        LoggerInterface $logger,
        Request $request
    ): Response {
        $contactModel = new ContactModel();
        $contactForm = $this->createForm(
            type: ContactType::class,
            data: $contactModel
        );
        $contactForm->handleRequest($request);
        if (
            $contactForm->isSubmitted()
            && $contactForm->isValid()
        ) {
            $logger->debug(
                "Vous avez reçu un message de {$contactModel->getName()}.",
                [
                    'to_contact' => $contactModel->getEmail(),
                    'message' => $contactModel->getMessage(),
                ]
            );

            return new Response('Formulaire envoyé !');
        }

        return $this->render(
            view: 'contact/contact.html.twig',
            parameters: [
                'contact_form' => $contactForm,
            ]
        );
    }
}
