<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    #[Route('/', name: 'post.index')]
    public function index(PostRepository $postRepo): Response
    {
        $postList = $postRepo->findAll();

        return $this->render('post/index.html.twig', [
            'postList' => $postList
        ]);
    }

    #[Route('/posts/{id}/delete', name: "post.delete")]
    public function delete(Request $request, PostRepository $postRepo, $id, Post $post){
        // 1 : Transmettre l'id dans twig
        // 2 : Récupérer le post en fonction de l'id
        // $id = $request->get('id');
        // $post = $postRepo->findOneBy(['id' => $id]);
        // 3 : delete with repository
        $this->em->remove($post);
        $this->em->flush();
        // 4 : redirect to route index
        return $this->redirectToRoute('post.index');
    }

    #[Route('/posts/create', name: "post.create")]
    public function create(Request $request){
        $title = $request->get('title');

        if(isset($title)){
            $post = new Post();
            $post
                ->setTitle($title)
                ->setCreatedAt(new DateTime())
            ;
    
            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/form.html.twig');
    }
}
