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
}
