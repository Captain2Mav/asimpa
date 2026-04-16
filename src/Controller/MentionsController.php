<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MentionsController extends AbstractController
{
    #[Route('/Mentions légales', name: 'app_mentions')]
    public function index(): Response
    {
        return $this->render('mentions/index.html.twig', [
            
        ]);
    }
}
