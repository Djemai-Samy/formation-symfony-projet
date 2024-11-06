<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthentificationController extends AbstractController
{
    #[Route('/authentification', name: 'app_authentification_page')]
    public function index(Request $req, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Instancier l'objet utilisateur pour l'inscription
        $utilisateur = new Utilisateur();

        // Créer le formulaire d'inscription et le lier avec l'objet
        $inscriptionForm = $this->createForm(InscriptionType::class, $utilisateur);

        // Irriguer le formulaire avec les données de la requete
        $inscriptionForm->handleRequest($req);

        // Si le formulaire est soumis et valide
        if ($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()) {

            // Récuperer l'utilisateur de la base données en utilisant le mail fournit par l'utilisateur
            $utilisateurExistant = $utilisateurRepository->findOneBy(['email' => $utilisateur->getEmail()]);

            // Tester si l'utilisateur est déja inscript
            if ($utilisateurExistant) {
                // Rediriger l'utilisateur vers la pas d'authentification avec un message d'erreur
                return $this->redirectToRoute(
                    'app_authentification_page',
                    ['inscription' => ['status' => 'error', 'message' => 'UTILISATEUR_EXISTE']]
                );
            }

            // Hasher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getPassword()
            );

            // Mettre à jour le mot de passe avec la version hashée
            $utilisateur->setPassword($hashedPassword);

            // Enregistrer l'utilisateur dans la base de données
            $utilisateurRepository->sauvegarder($utilisateur, true);

            // Rédiriger l'utilisateur vers la page d'authentification avec un message de succés
            return $this->redirectToRoute(
                'app_authentification_page',
                ['inscription' => ['status' => 'success', 'message' => 'INSCRIPTION_REUSSIE']]
            );
        }

        $connexionForm = $this->createForm(ConnexionType::class);

        // Afficher la vue représentant la page d'authentification
        return $this->render('pages/authentification/index.html.twig', [
            'controller_name' => 'AthentificationController',
            "inscriptionForm" => $inscriptionForm,
            "connexionForm" => $connexionForm,

        ]);
    }

    #[Route('/connexion', name: 'app_connexion')]
    function connexionTraitement(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $dernierEmail = $authenticationUtils->getLastUsername();


        return $this->redirectToRoute('app_authentification_page', ['connexion' => ["error" => isset($error), "dernierEmail" => $dernierEmail]]);
    }

    #[Route('/logout', name: 'app_deconnexion')]
    public function logout()
    {
        // Controleur peut etre vide!
    }
}
