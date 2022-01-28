<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
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

    #[Route('/posts/{id}/update', name: "post.update")]
    #[Route('/posts/create', name: "post.create")]
    public function form(Request $request, Post $post = null)
    {
        if (is_null($post)) {
            $post = new Post();
        }

        $formBuilder = $this->createFormBuilder($post);
        $formBuilder
            ->add("title", TypeTextType::class, [
                "label" => "Entrez un titre"
            ])
            ->add("content")
            ->add('submit', SubmitType::class, [
                "label" => is_null($post->getId()) ? "Ajouter" : "Modifier"
            ]);

        $form = $formBuilder->getForm();

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
            "isCreated" => is_null($post->getId())
        ]);
    }
}
