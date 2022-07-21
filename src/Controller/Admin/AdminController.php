<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LanguageRepository;
use App\Form\LanguageType;
use App\Entity\Language;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AllanRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AllanType;

#[Route('/admin/', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('language', name: 'language')]
    public function languageIndex(Request $request, LanguageRepository $languageRepository): Response
    {
        $languages = $languageRepository->findAll();

        $newLanguage = new Language();

        $form = $this->createForm(LanguageType::class, $newLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newLanguage = $form->getData();

            $languageRepository->add($newLanguage, true);

            return $this->redirectToRoute('app_admin_language');
        }

        return $this->render('language/index.html.twig', [
            'languages' => $languages,
            'form' => $form->createView(),
        ]);
    }

    #[Route('language/delete/{id}', name: 'language_edit', methods: ['GET', 'DELETE'])]
    public function languageDelete($id, Request $request, LanguageRepository $languageRepository): Response
    {
        $languageRepository->remove($languageRepository->findOneBy(['id' => $id]), true);

        return $this->redirectToRoute('app_admin_language');
    }

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
