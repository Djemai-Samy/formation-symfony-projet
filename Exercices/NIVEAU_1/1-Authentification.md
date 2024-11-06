# 1. Projet Symfony : Authentification

## NOTE :

- Sur GitHub, créer une nouvelle 'Issue'.
- Sur votre ordinateur, créer la branche 'feature/authentification'.

## 1.1. Configuration des utilisateurs

### 1.1.1. Création de l'entité utilisateur

Créer l'entité qui représentera l'utilisateur et qui implémente les interfaces `PasswordAuthenticatedUserInterface` et `UserInterface`.

- id : entier, unique, autogénéré
- email : string, unique
- password : string
- roles : tableau
- pseudo : string
- description : string, taille max : 500, peut être nul
- avatar : string, peut être nul
- emploi : string, peut être nul
- téléphone : string, peut être nul
- siteURL : (URL du site web de l'utilisateur) : string, peut être nul

---

### 1.1.2. Création du Repository

- Créer le fichier `UtilisateurRepository`.
- Implémenter la méthode `sauvegarder` qui permet d'enregistrer l'utilisateur dans la base de données.

---

### 1.1.3. Effectuer une migration

- Utiliser les commandes de Symfony pour créer et exécuter une migration.
- Vérifier que la migration a bien été effectuée sur votre base de données.

---

## 1.2. Inscription

### 1.2.1. Création du formulaire

Créer une classe formulaire avec les champs suivants :

- email : obligatoire, de type email
- pseudo : obligatoire, taille minimale : 3, taille maximale : 50
- password : de type password, obligatoire, taille minimale : 6
- confirmPassword : identique au champ password
- bouton de soumission du formulaire

Configurer les messages d'erreur, les placeholders, les labels, etc.

---

### 1.2.2. Affichage du formulaire

Afficher le formulaire sur la page d'authentification.

---

### 1.2.3. Traitement de l'inscription

Traiter l'inscription :

- Vérifier si l'utilisateur existe déjà (s'il est déjà inscrit), et afficher un message d'erreur approprié.
- Hasher le mot de passe.
- Enregistrer l'utilisateur dans la base de données.
- Afficher un message de réussite.

---

## 1.4. Connexion

### 1.4.1. Configuration

Configurer l'authentification dans le fichier de configuration `security.yaml`.

### 1.4.2. Formulaire de connexion

Créer une classe formulaire avec les champs suivants :

- email : obligatoire, de type email
- password : de type password, obligatoire, taille minimale : 6
- bouton de soumission du formulaire

---

### 1.4.3. Affichage du formulaire

Afficher le formulaire sur une page.

---

### 1.4.4. Traitement de la connexion

Ajouter la route avec le nom correspondant à ce que vous avez indiqué dans la configuration de `security.yaml`.

---

## 1.5. Page de profil

### 1.5.1. Création de la vue

Créer une nouvelle vue Twig `templates/pages/profile/index.html.twig` qui représentera la page de profil de l'utilisateur.

### 1.5.2. Création du contrôleur

- Créer un contrôleur `ProfilController`.
- Vérifier que l'utilisateur est connecté, sinon le rediriger vers la page d'authentification.
- Retourner la vue représentant la page de profil.

---

## 1.6. Déconnexion

### 1.6.1. Configuration

Configurer le système de déconnexion sur la route nommée `app_deconnexion` dans le fichier de configuration `security.yaml`.

---

### 1.6.2. Création de la route de déconnexion

- Dans le contrôleur `AuthentificationController`, ajouter une route sur l'URL `/deconnexion` nommée `app_deconnexion`.

---

## 1.7. Critères de réussite

---

## 1.8. Publication des modifications sur GitHub

### 1.8.1. Critères de réussite/acceptation

#### Inscription

- La page où le formulaire d'inscription est implémenté est navigable.
- Le formulaire s'affiche et possède les champs nécessaires.
- Si l'utilisateur est déjà inscrit, afficher une erreur dans la vue.
- L'inscription fonctionne, l'utilisateur est enregistré dans la base de données avec le mot de passe hashé.
- Afficher un message de réussite.
- Un utilisateur connecté doit être redirigé vers la page de profil.

#### Connexion

- La page où le formulaire de connexion est implémenté est navigable.
- Le formulaire s'affiche et possède les champs nécessaires.
- Si l'utilisateur n'est pas déjà inscrit, afficher une erreur dans la vue.
- La connexion fonctionne, l'utilisateur est authentifié et redirigé vers la page de profil.
- Un utilisateur connecté doit être redirigé vers la page de profil.

#### Page de profil

- La page de profil est navigable.
- L'utilisateur non connecté est redirigé vers la page de connexion.

---

#### Publication sur GitHub

- Effectuer un commit.
- Publier le code sur le repository Git.
- Créer une pull request.
- Notifier le formateur.
