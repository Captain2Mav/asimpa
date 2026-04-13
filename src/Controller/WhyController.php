<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WhyController extends AbstractController
{
    #[Route('/Pourquoi faire appel', name: 'app_why')]
    public function index(): Response
    {
        return $this->render('why/index.html.twig', [
            
        ]);
    }
}
