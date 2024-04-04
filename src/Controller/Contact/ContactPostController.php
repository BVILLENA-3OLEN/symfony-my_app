<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Form\FormType\Contact\ContactType;
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
    public function __invoke(Request $request): Response
    {
        $contactForm = $this->createForm(
            type: ContactType::class
        );
        $contactForm->handleRequest($request);

        return new Response('Formulaire envoyé !');
    }
}
