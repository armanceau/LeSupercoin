<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnoncesRepository;

class ProductController extends AbstractController
{
    #[Route('/product{id?0}', name: 'app_product')]
    public function index(int $id, AnnoncesRepository $repos): Response
    {
        $annonce = $repos->find($id);
        $liste = $repos->findAll();

        // Vérifier si un produit avec cet ID a été trouvé
        if (!$annonce) {
            throw $this->createNotFoundException('Aucun produit trouvé pour cet ID : ' . $id);
        }

        return $this->render('product/index.html.twig', [
            'annonce' => $annonce,
            'annonces' => $liste,
        ]);
        
    }
}
