<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setCreatedAt(new \DateTimeImmutable());
            $review->setIsApproved(false);

            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Votre avis a bien été envoyé. Il sera publié après validation.');

            return $this->redirectToRoute('app_review');
        }

        $reviews = $em->getRepository(Review::class)->findBy(
            ['isApproved' => true],
            ['createdAt' => 'DESC']
        );

        return $this->render('review/index.html.twig', [
            'form' => $form->createView(),
            'reviews' => $reviews,
        ]);
    }
} 
