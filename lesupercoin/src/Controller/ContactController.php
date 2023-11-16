<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        // Crée le formulaire Symfony
        $form = $this->createFormBuilder()
            ->add('Email', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Sujet', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Contenu', TextareaType::class, [
                'label' => 'Corps du message',
                'attr' => ['rows' => 8], // Définissez le nombre de lignes pour le textarea
            ])
            ->add('Envoyer', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont disponibles dans $form->getData()
            $formData = $form->getData();

            $email = (new TemplatedEmail())
                ->from($formData['Email'])
                ->to('arthur.manceau1@outlook.fr')
                ->subject($formData['Sujet'])
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    'formData' => $formData,
                ]);

            $mailer->send($email);

            return $this->redirectToRoute('app_contact_succes');
        }
        // else{
        //     return $this->redirectToRoute('app_contact_error');
        // }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/succes', name: 'app_contact_succes')]
    public function succes(): Response
    {
        return $this->render('contact/succes.html.twig', [
           
        ]);
    }

    #[Route('/contact/error', name: 'app_contact_error')]
    public function error(): Response
    {
        return $this->render('contact/error.html.twig', [
           
        ]);
    }
}
