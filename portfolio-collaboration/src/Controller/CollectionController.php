<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionType;
use App\Repository\CollectionRepository;
use App\Repository\UtilisateurRepository;
use App\Service\Uploader;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CollectionController extends AbstractController
{

    public function __construct(
        private SluggerInterface $slugger,
        private CollectionRepository $collectionRepo,
        private UtilisateurRepository $utilisateurRepo,
        private Uploader $uploader,

    ) {}

    #[Route(path: "/collections/{id}", name: "app_collection_page")]
    function collectionDetaille($id)
    {
        $collection = $this->collectionRepo->find($id);
        if (!$collection) {
            return $this->redirectToRoute("app_profile_page");
        }

        return $this->render('pages/collections/collection.html.twig', ['collection' => $collection]);
    }

    #[Route(path: "/collections/collection/create", name: "app_collections_create")]
    public function creerCollection(
        Request $request,
    ): Response {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $utilisateur = $this->utilisateurRepo->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        $nouvelCollection = new Collection();
        $form = $this->createForm(CollectionType::class, $nouvelCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cover = $form->get('cover')->getData();
            if ($cover) {
                $coverFilename = $this->uploader->upload($cover, "covers");
                $nouvelCollection->setCover($coverFilename);
            }

            $nouvelCollection->setDate(new DateTimeImmutable());
            $utilisateur->addCollection($nouvelCollection);
            $this->utilisateurRepo->sauvegarder($utilisateur);
            return $this->redirectToRoute("app_profile_page");
        }

        return $this->render("pages/collections/create.html.twig", ['form' => $form]);
    }


    #[Route(path: '/collection/{id}/modifier', name: 'app_modification_collection_page')]
    function modifierCollection(
        $id,
        Request $request,
    ) {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $collection = $this->collectionRepo->find($id);

        if (!$collection) {
            return $this->redirectToRoute('app_accueil_page');
        }

        $form = $this->createForm(CollectionType::class, $collection);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $cover = $form->get('cover')->getData();
            if ($cover) {
                $coverFilename = $this->uploader->upload($cover, "covers");
                $collection->setCover($coverFilename);
            }

            $this->collectionRepo->sauvegarder($collection);
            return $this->redirectToRoute("app_collection_page", ['id' => $id]);
        }


        return $this->render('pages/collections/modifier.html.twig', ['form' => $form, "collection" => $collection]);
    }

    #[Route(path: '/collection/{id}/supprimer', name: 'app_supprimer_collection')]
    function supprimerCollection($id)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $collection = $this->collectionRepo->find($id);

        if (!$collection) {
            return $this->redirectToRoute("app_collection_page", ['id' => $id]);
        }

        $this->collectionRepo->supprimer($collection);

        return $this->redirectToRoute("app_profile_page");
    }

    #[Route(path: '/collections', name: 'app_collections_page')]
    public function collectionsPage(Request $req): Response
    {
        $query = $req->query->has("query") ? $req->query->get("query") : "";
        $page = $req->query->has("page") ? $req->query->get("page") : 0;
        $collection = $this->collectionRepo->search($page, true, $query);
        return $this->render('pages/collections/index.html.twig', ['collections' => $collection]);
    }
}
