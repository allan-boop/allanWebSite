<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AllanRepository;

class AProposController extends AbstractController
{
    #[Route('/a/propos', name: 'app_a_propos')]
    public function index( AllanRepository $allanRepository ): Response
    {
        $allan = $allanRepository->findOneBy(['prenom' => 'Allan']);
        
        return $this->render('a_propos/index.html.twig', [
            'allan' => $allan,
        ]);
    }
}
