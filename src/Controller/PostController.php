<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        $posts=$postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' =>$posts,
        ]);
    }
             #[Route('/post/new', name:'app_post_new')]
             #[IsGranted('ROLE_ADMIN')]
        public function new(Request $request, EntityManagerInterface $em):Response
        { 
            $post= new Post();
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                
            $post->setCreatedAt(new DateTimeImmutable() );
            $post->setUser($this->getUser());
                     $em->persist($post);
	                 $em->flush();

                 return $this->redirectToRoute('app_post');
            }       
            
        return $this->render('post/new.html.twig',[
            'form'=> $form->createView(),
              
        ]);
    
        }


        #[Route('/post/{id}', name:'app_post_show')]
        public function show(int $id, PostRepository $postRepository,Request $request ,EntityManagerInterface $em): Response
        {
            $post= $postRepository->find($id);
             $comment = new Comment();

              $form = $this->createForm(CommentFormType::class, $comment);
              $form->handleRequest($request);
              
         if ($form->isSubmitted() && $form->isValid()) {
              $comment->setPost($post);

            $em->persist($comment);
              $em->flush();

         return $this->redirectToRoute('app_post_show', ['id'=>$post->getId()]);
    
}
            return $this->render('post/show.html.twig', [
                'form' =>$form->createView(),
                'post' =>$post
               
            ]);
             
             
        }

        #[Route('/post/{id}/edit', name:'app_post_edit')]
         #[IsGranted('ROLE_ADMIN')]
        public function edit(int $id, PostRepository $postRepository, Request $request, EntityManagerInterface $em):Response
        {
            $post= $postRepository->find($id);
             $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              
            $em->flush();

            return $this->redirectToRoute('app_post_show',
            [
                'id'=> $post->getId()
            ]);
             
            }
               return $this->render('post/edit.html.twig', [
                'form'=> $form->createView(),
               ]);
        }

        #[Route('/post/{id}/delete', name:'app_post_delete')]
         #[IsGranted('ROLE_ADMIN')]
        public function delete(int $id, PostRepository $postRepository, EntityManagerInterface $entityManager, Request $request):Response
       {
        $post= $postRepository->find($id);

         if(!$post){
            throw $this->createNotFoundException ();
        }
        
        $token = $request->request->get('app_post_delete');

       
    if ($this->isCsrfTokenValid('delete-post-'.$post->getId(), $token)){
         $entityManager->remove($post);
          $entityManager->flush();
          
        
    }
       
          return $this->redirectToRoute('app_post',);                    
                                                            
       }
         
    

};
