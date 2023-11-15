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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriesRepository;
use App\Repository\AnnoncesRepository;

class FormsController extends AbstractController
{
    #[Route('/forms/users', name: 'app_forms_users')]
    public function registerUsers(Request $request, UsersRepository $repos): Response
    {
        // Crée une instance de l'entité Users
        $users = new Users();

        // Crée le formulaire Symfony
        $form = $this->createFormBuilder($users)
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create User',
                'attr' => ['class' => 'btn btn-primary'], // Ajoute la classe Bootstrap 'btn btn-primary' au bouton
            ])
            ->getForm();

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
        return $this->render('forms/users.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/forms/annonces', name: 'app_forms_annonces')]
    public function registerAnnonces(Request $request, AnnoncesRepository $reposAnnonces, CategoriesRepository $reposCategories): Response
    {
        // Crée une instance de l'entité Users
        $annonces = new Annonces();

        // Crée le formulaire Symfony
        $form = $this->createFormBuilder($annonces)
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('prix', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('content', TextType::class, [
                'attr' => ['class' => 'form-control'], // Ajoute la classe Bootstrap 'form-control' à l'input
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer une anonce',
                'attr' => ['class' => 'btn btn-primary'], // Ajoute la classe Bootstrap 'btn btn-primary' au bouton
            ])
            ->getForm();

        $annonces->setCreatedat(new \DateTimeImmutable('tomorrow'));
        $annonces->setUpdatedat(new \DateTimeImmutable('tomorrow'));

        $test = $reposCategories->find(1);

        $annonces->setCategories($test);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont disponibles dans $form->getData()
            $formData = $form->getData();

            // Utilisez le repository pour enregistrer les données en base de données
            $reposAnnonces->save($formData);

            // Redirige vers une autre page ou affiche un message de réussite
            return $this->redirectToRoute('app_default');
        }
        // Rendu de la vue avec le formulaire
        return $this->render('forms/annonces.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
