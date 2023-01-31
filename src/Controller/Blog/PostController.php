<?php

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post' ,methods:['GET'])]
    public function index(PostRepository $repository): Response
    {
        $post = $repository->findPublished();
        
        return $this->render('pages/post/index.html.twig', [
            'post' => $post,
        ]);
    }
}

