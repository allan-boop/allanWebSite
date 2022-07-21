<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AllanRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AllanType;

#[Route('/edit/', name: 'app_edit_')]
class EditController extends AbstractController
{
    #[Route('allan', name: 'allan')]
    public function editAllan(Request $request, AllanRepository $allanRepository, EntityManagerInterface $manager): Response
    {
        $allan = $allanRepository->findOneBy(['prenom' => 'Allan']);
        $form = $this->createForm(AllanType::class, $allan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allan = $form->getData();

            $manager->persist($allan);
            $manager->flush();

            $this->addFlash(
                'success',
                'Allan à été modifié !'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('edit/allan.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
