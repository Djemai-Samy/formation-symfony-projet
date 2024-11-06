# 2. Projet Symfony : Page de profil

## 2.1. Afficher les informations de l'utilisateur

Dans le fichier Twig représentant la page de profil, afficher :

- L'avatar de l'utilisateur (ou une image par défaut si l'avatar est nul)
- Le pseudo de l'utilisateur
- La description de l'utilisateur (ou vide si la description est nulle)
- L'email de l'utilisateur
- L'emploi de l'utilisateur s'il existe
- Le numéro de téléphone de l'utilisateur s'il existe
- L'URL du site de l'utilisateur s'il existe

## 2.2. Création du formulaire

### 2.2.1. Définition du formulaire

Créer une classe formulaire avec :

- avatar : champ de type fichier, non obligatoire
- pseudo : champ de type texte, obligatoire, min : 6, max : 50
- emploi : champ de type texte, non obligatoire, min : 6, max : 50
- description : champ de type textarea, non obligatoire, max : 500
- Bouton de soumission du formulaire

## 2.3. Affichage du formulaire

Dans le contrôleur `ProfileController`, ajouter une nouvelle route nommée `app_modifier_informations` sur l'URL `/profile/update` :

- Vérifier que l'utilisateur est authentifié, sinon le rediriger vers la page d'authentification.
- Récupérer l'utilisateur depuis la base de données en utilisant la session.
- Créer le formulaire en liant l'objet de type `Utilisateur` récupéré de la base de données.
- Envoyer le formulaire à la vue.
- Afficher et personnaliser le formulaire dans la Twig.

## 2.4. Traitement du formulaire

Dans le contrôleur `ProfileController`, sur la route `app_modifier_informations` :

Traiter les données du formulaire si celui-ci est valide et soumis :

- Si l'avatar n'est pas nul, sauvegarder le fichier (en suivant la documentation sur l'upload de fichiers : [Symfony Documentation](https://symfony.com/doc/current/controller/upload_file.html)).
- Mettre à jour l'avatar de l'objet `$utilisateur` avec le nom du fichier créé.
- Enregistrer l'utilisateur dans la base de données.
- Rediriger l'utilisateur vers la page de profil.

---

## 2.5. Publier votre cod sur Github

### 2.5.1. Critères de réussite/acceptatio

#### Affichage des informations

- La page de profil est navigable et s'affiche correctement.
- Les informations de l'utilisateur (avatar, pseudo, description, etc.) s'affichent selon les conditions définies.
- L'avatar par défaut est affiché lorsque l'utilisateur n'a pas d'avatar.

#### Formulaire de modification

- La page contenant le formulaire de modification est accessible et navigable.
- Si l'utilisateur n'est pas authentifié, il est redirigé vers la page de connexion.
- Le formulaire s'affiche avec les champs requis et respecte les validations définies (ex. pseudo de longueur correcte, description ≤ 500 caractères).

#### Traitement du formulaire

- Le formulaire est traité correctement lorsqu'il est soumis et valide.
- Si un fichier avatar est soumis, il est sauvegardé dans le répertoire approprié.
- Les informations de l'utilisateur sont mises à jour correctement dans la base de données.
- L'utilisateur est redirigé vers la page de profil après la mise à jour réussie.

#### Gestion des erreurs

- Si le formulaire est invalide, des messages d'erreur appropriés s'affichent.
- Si l'upload du fichier échoue, un message d'erreur clair est affiché.

### Publication sur GitHub

- Faites un commit avec un message approprié.
- Publier le code sur le repository Git.
- Créer Une pull request et notofié le formateur
