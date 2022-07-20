<?php

namespace App\Service;

use App\Entity\FormulaireContact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persistContact(FormulaireContact $contact)
    {
        $contact->setIsSend(false)->setCreatedAt(new DateTime('now'));

        $this->manager->persist($contact);
        $this->manager->flush();
        return ['success', 'Votre message à bien été envoyé, merci'];
    }

    public function isSend(FormulaireContact $contact): void
    {
        $contact->setIsSend(true);

        $this->manager->persist($contact);
        $this->manager->flush();
        
    }
}
