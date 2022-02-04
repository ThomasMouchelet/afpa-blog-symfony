<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'post.index')]
    public function index(PostRepository $postRepo): Response
    {
        $postList = $postRepo->findBy([], ['createdAt' => 'DESC']);

        return $this->render('post/index.html.twig', [
            'postList' => $postList
        ]);
    }

    #[Route('/posts/{id}', name: "post.show")]
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', ['post' => $post]);
    }
}
