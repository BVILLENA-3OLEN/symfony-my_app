<?php

declare(strict_types=1);

namespace App\Model\Form\Contact;

final class ContactModel
{
    private ?string $name = null;
    private ?string $email = null;
    private ?\DateTime $appointmentDate = null;
    private ?string $message = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAppointmentDate(): ?\DateTime
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate(?\DateTime $appointmentDate): static
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
