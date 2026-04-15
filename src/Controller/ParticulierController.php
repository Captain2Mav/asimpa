<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ParticulierController extends AbstractController
{
    #[Route('/Particuliers', name: 'app_particulier')]
    public function index(): Response
    {
        return $this->render('particulier/index.html.twig', [
            
        ]);
    }
}
