<?php

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post' ,methods:['GET'])]
    public function index(PostRepository $repository,PaginatorInterface $paginatorInterface,Request $request): Response
    {
        $data = $repository->findPublished();
        $post = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page',1),
            9

        );
        
        return $this->render('pages/post/index.html.twig', [
            'post' => $post,
        ]);
    }
}

