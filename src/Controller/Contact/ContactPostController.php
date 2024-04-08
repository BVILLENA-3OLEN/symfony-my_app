<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Form\FormType\Contact\ContactType;
use App\Model\Form\Contact\ContactModel;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/contact',
    name: 'app_contact_post',
    methods: 'POST'
)]
final class ContactPostController extends AbstractController
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

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
            $this->sendMail($contactModel);

            return new Response('Formulaire envoyé !');
        }

        return $this->render(
            view: 'contact/contact.html.twig',
            parameters: [
                'contact_form' => $contactForm,
            ]
        );
    }

    private function sendMail(ContactModel $contactModel): void
    {
        $email = new Email();
        $email->sender( // Qui envoie le mail ?
            new Address(
                $contactModel->getEmail(),
                $contactModel->getName()
            )
        );
        $email->to( // Qui reçoit le mail ?
            new Address(
                'billy.villena@lyon.ort.asso.fr',
                'Billy Framework 3OLEN'
            )
        );
        $email->subject('Message de contact');
        $email->text(
            "Bonjour,\n"
            . "Je vous contacte selon :\n"
            . $contactModel->getMessage()
            . "\nDate d'envoi de message : "
            . (new \DateTime())->format('d/m/Y')
            . "\nDate de rdv voulue : "
            . $contactModel->getAppointmentDate()->format('d/m/Y')
            . "\n\nMerci,\n"
            . "Bonne journée.\n"
            . $contactModel->getName()
        );

        $this->mailer->send($email);
    }
}
