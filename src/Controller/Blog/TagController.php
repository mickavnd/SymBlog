<?php

namespace App\Controller\Blog;

use App\Entity\Post\Tags;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etiquette')]
class TagController extends AbstractController
{
    #[Route('/{slug}', name: 'tags_index')]
    public function index( Tags $tags,PostRepository $postRepository ,Request $request): Response
    {       
        $posts = $postRepository->findPublished($request->query->getInt('page',1),null,$tags);

       

        return $this->render('pages/tag/index.html.twig', [
            'tags' => $tags,
            'posts'=>$posts

        ]);
    }
}
