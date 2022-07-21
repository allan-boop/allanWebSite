<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LanguageRepository;
use App\Form\LanguageType;
use App\Entity\Language;
use Symfony\Component\HttpFoundation\Request;


class LanguageController extends AbstractController
{
    #[Route('/language', name: 'app_language')]
    public function index(Request $request, LanguageRepository $languageRepository): Response
    {
        $languages = $languageRepository->findAll();

        $newLanguage = new Language();

        $form = $this->createForm(LanguageType::class, $newLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newLanguage = $form->getData();

            $languageRepository->add($newLanguage, true);

            return $this->redirectToRoute('app_language');
        }

        return $this->render('language/index.html.twig', [
            'languages' => $languages,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/language/delete/{id}', name: 'app_language_edit', methods: ['GET', 'DELETE'])]
    public function delete($id, Request $request, LanguageRepository $languageRepository): Response
    {
        $languageRepository->remove($languageRepository->findOneBy(['id' => $id]), true);


        return $this->redirectToRoute('app_language');
    }
}
