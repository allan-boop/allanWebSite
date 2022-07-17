<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AllanRepository;
use App\Repository\LanguageRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AllanRepository $allanRepository, LanguageRepository $languageRepository): Response
    {
        $allan = $allanRepository->findOneBy(['prenom' => 'Allan']);
        $languages = $languageRepository->findAll();
        return $this->render('home/index.html.twig', [
            'allan' => $allan,
            'languages' => $languages,
        ]);
    }
}
