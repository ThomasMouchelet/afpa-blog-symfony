<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'post.index')]
    public function index(PostRepository $postRepo): Response
    {
        $postList = $postRepo->findAll();

        return $this->render('post/index.html.twig', [
            'postList' => $postList
        ]);
    }

    #[Route('/posts/{id}/delete', name: "post.delete")]
    public function delete(){
        // 1 : Transmettre l'id dans twig
        // 2 : Récupérer le post en fonction de l'id
        // 3 : delete with repository
        // 4 : redirect to route index
        dd('Delete');
    }
}
