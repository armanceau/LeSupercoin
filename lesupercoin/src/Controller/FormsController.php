<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormsController extends AbstractController
{
    #[Route('/forms', name: 'app_forms')]

    public function register(Request $request): Response
    {
        $annonces = new Annonces();
        $annonces->setTask('Write a blog post');
        $annonces->setDueDate(new \DateTimeImmutable('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();


        return $this->render('forms/new.html.twig', [
            'form' => $form,
        ]);
        // return $this->render('forms/index.html.twig', [
        //     'controller_name' => 'FormsController',
        // ]);
    }
}
