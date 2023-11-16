<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriesRepository;
use App\Repository\AnnoncesRepository;

class ProductController extends AbstractController
{
    #[Route('/product/{id?0}', name: 'app_product')]
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
    #[Route('/product/delete/{id}', name: 'app_product_delete')]
    public function delete(int $id, AnnoncesRepository $repos, Request $request): Response
    {
        $annonce = $repos->find($id);

        $repos->remove($annonce);

        return $this->redirectToRoute('app_default');   
    }

    #[Route('/product/edit/{id}', name: 'app_product_edit')]
    public function edit(int $id, AnnoncesRepository $repos, Request $request): Response
    {

        $annonces = $repos->find($id);

        // Crée le formulaire Symfony
        $form = $this->createFormBuilder($annonces)
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('prix', IntegerType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('content', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Modifier cette annonce',
                'attr' => ['class' => 'btn btn-primary'], // Ajoute la classe Bootstrap 'btn btn-primary' au bouton
            ])
            ->getForm();

            $annonces->setUpdateDat(new \DateTimeImmutable());

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont disponibles dans $form->getData()
            $formData = $form->getData();

            // Utilisez le repository pour enregistrer les données en base de données
            $repos->save($formData);

            // Redirige vers une autre page ou affiche un message de réussite
            return $this->redirectToRoute('app_default');
        }
        // Rendu de la vue avec le formulaire
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
}
