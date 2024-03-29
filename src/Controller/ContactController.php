<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Message pour informer l'utilisateur que le message est envoyé
            $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équipe vous fera patienter un maximum de temps.');

            //Récupération des inputs du formulaire de contact
            //dd($form->getData());
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        
        ]);
    }
}
