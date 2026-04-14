<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrganismeController extends AbstractController
{
    #[Route('/Organisme public/privés', name: 'app_organisme')]
    public function index(): Response
    {
        return $this->render('organisme/index.html.twig', [
           
        ]);
    }
}
