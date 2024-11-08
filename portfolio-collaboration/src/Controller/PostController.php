<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Entity\Post;
use App\Form\CollectionType;
use App\Form\PostType;
use App\Repository\CollectionRepository;
use App\Repository\PostRepository;
use App\Repository\UtilisateurRepository;
use App\Service\Uploader;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostController extends AbstractController
{

    public function __construct(
        private SluggerInterface $slugger,
        private UtilisateurRepository $utilisateurRepo,
        private CollectionRepository $collectionRepo,
        private PostRepository $postRepo,
        private Uploader $uploader,
    ) {}


    #[Route(path: "/collections/{id}/post/create", name: "app_post_create")]
    public function creerPost(
        Request $request,
        $id
    ): Response {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $collection = $this->collectionRepo->find($id);

        if (!$collection) {
            return $this->redirectToRoute('app_profile_page');
        }

        $nouveauPost = new Post();
        $form = $this->createForm(PostType::class, $nouveauPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $imageFilename = $this->uploader->upload($image, "images");
                $nouveauPost->setImage($imageFilename);
            }

            $collection->addPost($nouveauPost);
            $this->collectionRepo->sauvegarder($collection);
            return $this->redirectToRoute("app_collection_page", ['id' => $id]);
        }

        return $this->render("pages/posts/create.html.twig", ['form' => $form]);
    }

    #[Route(path: '/posts/{id}/modifier', name: 'app_modification_post_page')]
    function modifierPost(
        $id,
        Request $request,
    ) {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $post = $this->postRepo->find($id);

        if (!$post) {
            return $this->redirectToRoute('app_accueil_page');
        }

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $imageFilename = $this->uploader->upload($image, "images");
                $post->setImage($imageFilename);
            }

            $this->postRepo->sauvegarder($post);
            return $this->redirectToRoute("app_collection_page", ['id' => $post->getCollection()->getId()]);
        }
        return $this->render('pages/posts/modifier.html.twig', ['form' => $form, "post" => $post]);
    }

    #[Route(path: '/posts/{id}/supprimer', name: 'app_supprimer_post')]
    function supprimerPost($id)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $post = $this->postRepo->find($id);

        if (!$post) {
            return $this->redirectToRoute("app_profile_page");
        }

        $this->postRepo->supprimer($post);

        return $this->redirectToRoute("app_collection_page", ['id' => $post->getCollection()->getId()]);
    }
}
