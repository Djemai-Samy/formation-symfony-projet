<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Form\ProfileType;
use App\Repository\UtilisateurRepository;
use App\Service\Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile_page')]
    function afficherProfile(UtilisateurRepository $utilisateurRepository)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $sessionUtilisateur = $this->getUser();
        $utilisateurDB = $utilisateurRepository->findOneBy(['email' => $sessionUtilisateur->getUserIdentifier()]);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_authentification_page');
        }

        return $this->render('pages/profile/index.html.twig', ['utilisateur' => $utilisateurDB]);
    }

    #[Route('/profile/modification', name: 'app_modification_profile_page')]
    function modifierProfile(
        UtilisateurRepository $utilisateurRepository,
        Request $request,
        Uploader $uploader
    ) {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $sessionUtilisateur = $this->getUser();
        $utilisateurDB = $utilisateurRepository->findOneBy(['email' => $sessionUtilisateur->getUserIdentifier()]);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $profileForm = $this->createForm(ProfileType::class, $utilisateurDB);

        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {

            $avatarFichier = $profileForm->get('avatar')->getData();
            if ($avatarFichier) {
                $newAvatar = $uploader->upload($avatarFichier, "avatars");
                $utilisateurDB->setAvatar($newAvatar);
            }

            $utilisateurRepository->sauvegarder($utilisateurDB);
            return $this->redirectToRoute('app_profile_page');
        }

        return $this->render('pages/profile/modification.html.twig', ['utilisateur' => $utilisateurDB, 'profileForm' => $profileForm]);
    }
}
