<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnoncesRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(AnnoncesRepository $repos): Response
    {

        $liste = $repos->findAll();

        return $this->render('default/index.html.twig',[
            'annonces' => $liste,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('default/about.html.twig',[
            
        ]);
    }
}
