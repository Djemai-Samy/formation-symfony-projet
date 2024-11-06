<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Form\ProfileType;
use App\Repository\UtilisateurRepository;
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
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/images/avatars')] string $brochuresDirectory
    ) {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_authentification_page');
        }

        $sessionUtilisateur = $this->getUser();
        $utilisateurDB = $utilisateurRepository->findOneBy(['email' => $sessionUtilisateur->getUserIdentifier()]);

        if (!$utilisateurDB) {
            return $this->redirectToRoute('app_authentification_page');
        }

        // Créer le formulaire d'inscription et le lier avec l'objet
        $profileForm = $this->createForm(ProfileType::class, $utilisateurDB);

        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {

            $avatarFichier = $profileForm->get('avatar')->getData();
            if ($avatarFichier) {
                $originalFilename = pathinfo($avatarFichier->getClientOriginalName(), PATHINFO_FILENAME);
                // Créer un nom sécurisé et unique pour le fichier en utilisant le nom original
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFichier->guessExtension();

                // Déplacer le ficher vers le dossier avatars
                try {
                    $avatarFichier->move($brochuresDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... Gérer le cas ou un problème est survenue
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $utilisateurDB->setAvatar($newFilename);
            }

            $utilisateurRepository->sauvegarder($utilisateurDB);
            return $this->redirectToRoute('app_profile_page');
        }

        return $this->render('pages/profile/modification.html.twig', ['utilisateur' => $utilisateurDB, 'profileForm' => $profileForm]);
    }
}
