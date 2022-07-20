<?php

namespace App\Controller;

use App\Entity\FormulaireContact;
use App\Form\FormulaireContactType;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireContactController extends AbstractController
{
    #[Route('/formulaire/contact', name: 'app_formulaire_contact')]
    public function index(
        Request $request,
        ContactService $contactService
    ): Response {
        $contact = new FormulaireContact();

        $form = $this->createForm(FormulaireContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $result = $contactService->persistContact($contact);
            $this->addFlash($result[0], $result[1]);

            return $this->redirectToRoute('app_formulaire_contact');
        }

        return $this->render('formulaire_contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
