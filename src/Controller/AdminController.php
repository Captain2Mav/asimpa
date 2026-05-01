<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin', name: 'app_admin_')]
#[IsGranted ('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    
    #[Route('/', name: 'dashboard')]
    public function dashboard(PostRepository $postRepo, CommentRepository $commentRepo): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'postsCount' => count($postRepo->findAll()),
            'commentsCount' => count($commentRepo->findAll()),
        ]);
    }


    #[Route('/comments', name: 'comments')]
    public function comments(CommentRepository $commentRepo): Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepo->findAll(),
        ]);
    }

    
    #[Route('/comment/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function deleteComment(Comment $comment, EntityManagerInterface $em): Response
    {
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('app_admin_comments');
    }

   
    #[Route('/posts', name: 'posts')]
    public function posts(PostRepository $postRepo): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepo->findAll(),
        ]);
    }

  
    #[Route('/post/{id}/delete', name: 'post_delete', methods: ['POST'])]
    public function deletePost(Post $post, EntityManagerInterface $em): Response
    {
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('app_admin_posts');
    }



}
