<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\CollectionRepository;
use App\Repository\UtilisateurRepository;
use App\Service\Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    public function __construct(private UtilisateurRepository $utilisateurRepository, private Uploader $uploader) {}

    #[Route('/profile', name: 'app_profile_page')]
    function afficherProfile(Request $req,  CollectionRepository $collectionRepo,)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $sessionUtilisateur = $this->getUser();
        $utilisateurDB = $this->utilisateurRepository->findOneBy(['email' => $sessionUtilisateur->getUserIdentifier()]);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $query = $req->query->has("query") ? $req->query->get("query") : "";
        $page = $req->query->has("page") ? $req->query->get("page") : 0;
        $collections = $collectionRepo->search($page, false, $query, $utilisateurDB->getId());

        return $this->render('pages/profile/index.html.twig', ['utilisateur' => $utilisateurDB, "collections" => $collections]);
    }

    #[Route('/profile/modification', name: 'app_modification_profile_page')]
    function modifierProfile(
        Request $request,
    ) {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $sessionUtilisateur = $this->getUser();
        $utilisateurDB = $this->utilisateurRepository->findOneBy(['email' => $sessionUtilisateur->getUserIdentifier()]);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $profileForm = $this->createForm(ProfileType::class, $utilisateurDB);

        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {

            $avatarFichier = $profileForm->get('avatar')->getData();
            if ($avatarFichier) {
                $newAvatar = $this->uploader->upload($avatarFichier, "avatars");
                $utilisateurDB->setAvatar($newAvatar);
            }

            $this->utilisateurRepository->sauvegarder($utilisateurDB);
            return $this->redirectToRoute('app_profile_page');
        }

        return $this->render('pages/profile/modification.html.twig', ['utilisateur' => $utilisateurDB, 'profileForm' => $profileForm]);
    }

    #[Route('/user/{id}', name: 'app_user_page')]
    function profileUser($id, Request $req,  CollectionRepository $collectionRepo,)
    {
        $utilisateurDB = $this->utilisateurRepository->find($id);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_accueil_page');
        }
        $query = $req->query->has("query") ? $req->query->get("query") : "";
        $page = $req->query->has("page") ? $req->query->get("page") : 0;
        $collections = $collectionRepo->search($page, false, $query, $utilisateurDB->getId());

        return $this->render('pages/profile/index.html.twig', ['utilisateur' => $utilisateurDB, 'collections' => $collections]);
    }
}
