<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post' ,methods:['GET'])]
    public function index(PostRepository $repository,Request $request): Response
    {
        
        return $this->render('pages/post/index.html.twig', [
            
            'post' => $repository->findPublished($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/article/{slug}', name:'post_show', methods:['GET'])]
    public function show(Post $post):Response
    {
        // dd($post);
        
        return $this->render('pages/post/show.html.twig',[
            'posts'=> $post
        ]);
    }
}

