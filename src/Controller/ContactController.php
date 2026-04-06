<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer ): Response
    {
             $contact= new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
               
          $contact = $form->getData();  
           $email = (new Email())->from('test@test.com')

        ->to('test@test.com')
        ->subject('Nouveau message de contact')

        ->text( $contact->getFirstName().''. $contact->getLastName(). 'Vous a envoyé un message:'. $contact->getMessage());
       

         $mailer->send($email);
        

           $this->addFlash('success', 'Votre message a été envoyé avec succès');
            return $this->redirectToRoute('app_contact');
        }   
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
       
    }

  
   
}
