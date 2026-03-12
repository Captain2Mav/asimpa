<?php

namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
        
        public function new():Response
        { 
        return $this->render('post/new.html.twig',[
              
        ]);
    
        }


        #[Route('/post/{id}', name:'app_post_show')]
        public function show(int $id, PostRepository $postRepository): Response
        {
            $post= $postRepository->find($id);
            return $this->render('post/show.html.twig', [
                'post' =>$post, 
            ]);

        }

       

}
