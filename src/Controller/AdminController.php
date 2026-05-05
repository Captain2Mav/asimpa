<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Review;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\User;
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

    #[Route('/reviews', name: 'reviews')]
public function reviews(EntityManagerInterface $em): Response
{
    $reviews = $em->getRepository(Review::class)->findBy(
        ['isApproved' => false],
        ['createdAt' => 'DESC']
    );

    return $this->render('admin/review/index.html.twig', [
        'reviews' => $reviews,
    ]);
} 

   #[Route('/review/{id}/validate', name: 'review_validate')]
public function validate(Review $review, EntityManagerInterface $em): Response
{
    $review->setIsApproved(true);
    $em->flush();

    return $this->redirectToRoute('app_admin_reviews');
} 

     #[Route('/review/{id}/delete', name: 'app_admin_review_delete')]
public function delete(Review $review, EntityManagerInterface $em): Response
{
    $em->remove($review);
    $em->flush();

    return $this->redirectToRoute('app_admin_reviews');
} 

   #[Route('/users', name: 'users')]
public function users(UserRepository $userRepository): Response
{
    $users = $userRepository->findAll();

    return $this->render('admin/users/index.html.twig', [
        'users' => $users,
    ]);
} 
     #[Route('/users/{id}/toggle', name: 'user_toggle')]
public function toggleUser(User $user, EntityManagerInterface $em): Response
{
    if ($user === $this->getUser()) {
        return $this->redirectToRoute('app_admin_users');
    }

    $user->setIsActive(!$user->isActive());
    $em->flush();

    return $this->redirectToRoute('app_admin_users');
} 


}
