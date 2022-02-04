<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('admin/posts/create', name: "post.create")]
    #[Route('admin/posts/{id}/update', name: "post.update")]
    public function form(Request $request, Post $post = null)
    {
        if (!$post) {
            $post = new Post();
        }

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            if (!$post->getId()) {
                $post->setCreatedAt(new DateTime());
            }

            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/form.html.twig', [
            'form' => $form->createView(),
            "isCreated" => !$post->getId()
        ]);
    }

    #[Route('admin/posts/{id}/delete', name: "post.delete")]
    public function delete(Request $request, PostRepository $postRepo, $id, Post $post)
    {
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
}
