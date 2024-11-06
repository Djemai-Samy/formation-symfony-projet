# 1. Projet Symfony : Authentification

## 1.1. Configuration des utilisateurs

### 1.1.1. : Création de l'entité utilisateur

#### 1.1.1.1. Classe de base

Créer l'entité qui représentera l'utilisateur.
L'entité possédera les propriétés suivantes ainsi que les accesseurs et mutateurs :

- id : entier, unique, auto-généré
- email : string, unique
- password : string
- pseudo : string
- avatar : string, peut être null
- roles : Tableau

#### 1.1.1.2. Implémentation de l'interface `UserInterface`

Ajouter l'implémentation de l'interface : `UserInterface`, ainsi que les propriétés et méthodes nécessaires.

#### 1.1.1.3. Implémentation de l'interface pour le mot de passe

Ajouter l'implémentation de l'interface : `PasswordAuthenticatedUserInterface`, ainsi que les propriétés et méthodes nécessaires.

---

### 1.1.2. : Création du Repository

- Créer le fichier `UtilisateurRepository`.
- Créer la classe `UtilisateurRepository` qui hérite de `ServiceEntityRepository`.
- Implémenter le constructeur en injectant le Service `ServiceEntityRepository`, et instanciant la classe parent.
- Implémenter la méthode `sauvegarder` qui permet d'enregistrer l'utilisateur dans la base de données.

---

### 1.1.3. : Effectuer une migration

- Utiliser les commandes de Symfony pour créer et exécuter une migration.
- Vérifier que la migration a bien été effectuée sur votre base de données.

---

## 1.2. Page d'authentification

### 1.2.1. La vue :

Créer un nouveau template Twig `templates/pages/authentification/index.html.twig`, qui hérite du template de base.

### 1.2.2. Le contrôleur :

Créer un Contrôleur : `Controller/AuthentificationController.php`, qui hérite du contrôleur de base `AbtractController`.

### 1.2.3. La route :

Ajouter au contrôleur : `AuthentificationController.php`, une route sur l'URL `/authentification` nommée `app_authentification_page`.
Retourner la vue créée plus tôt.

## 1.3. Inscription :

### 1.3.1. Formulaire d'inscription :

Créer une classe formulaire nommée `InscriptionType` avec les champs suivants :

- email : Obligatoire, de type email
- pseudo : Obligatoire, taille minimale 3, taille maximale : 50
- password : Type Password, Obligatoire, Taille minimale 6
- confirmPassword : Identique au champ password
- Bouton de soumission du formulaire

Configurez les messages d'erreurs, placeholders, labels ...

### 1.3.2. Afficher le formulaire :

Dans la route nommée `app_authentification_page` du contrôleur `AuthentificationController` :

- Instancier un objet de type `Utilisateur`.
- Créer un formulaire de type `InscriptionForm` et liez-le avec l'objet `$utilisateur` instancié.
- Dans le template Twig, afficher le formulaire et configurez-le avec vos styles.

### 1.3.3. Traitement de l'inscription

Dans la route nommée `app_authentification_page` du contrôleur `AuthentificationController` :

- Injectez et hydratez le formulaire avec la requête de Symfony.
- Vérifier si le formulaire est soumis et valide :
  - Vérifier que l'utilisateur n'existe pas, et rediriger sur la route `app_authentification_page` en ajoutant dans les query la clé `'inscription'` pour valeur un tableau associatif :
    - la clé `status` avec la valeur `'error'`
    - la clé `message` avec la valeur `'UTILISATEUR_EXISTE'`
  - Hasher le mot de passe de l'utilisateur et le stocker dans l'objet `$utilisateur`.
  - Enregistrer l'utilisateur dans la base de données.
  - Rediriger sur la route `app_authentification_page` en ajoutant dans les query la clé `'inscription'` pour valeur un tableau associatif :
    - la clé `status` avec la valeur `'success'`
    - la clé `message` avec la valeur `'INSCRIPTION_REUSSIE'`

Dans le template Twig `templates/pages/authentification/index.html.twig` :

- Utiliser les "queries" de l'URL `app.query` pour récupérer le status et le message.
- Utiliser un bloc de condition pour afficher les messages d'erreur ou de réussite avec le style approprié.

NOTE :

- N'oubliez pas de tester les messages d'erreur et de succès.
- N'oubliez pas de tester l'inscription et vérifier si l'utilisateur est bien ajouté dans la base de données.

---

## 1.4. Connexion :

### 1.4.1 Configuration

Configurez l'authentification dans le fichier de configuration `security.yaml`:

- Indiquez l'entité representant les utilisateurs
- Activez l'authentification par formulaire en utilisant email et password pour les champs
- Indiquer la route nommée `app_connexion` comme etant la route d'authentification.

### 1.4.2 Route de connexion

Dans le controller `AuthentificationController`, créer la route `app_connexion`:

- Refidirige l'utilisateur su la route `app_authentification_page`

---

## 1.5. Page de profile :

### 1.4.1 Création de la vue:

Créez un nouvelle Twig `templates/pages/profile/index.html.twig` qui reprensentera la page de profile de l'utilisateur.

### 1.4.1 Création du controleur

- Créer un Controller `ProfilController`.
- Vérifier que l'utilisateur est connecté, sinon le rediriger vers la page d'authentification.
- Retourner la vue représentant la page de profile..

## 1.5. Déconnexion :

### 1.5.1. Configuration:

Configurez le system de déconnexion sur la route nommée `app_deconnexion` dans le fichier de configuration `security.yaml`.

---

### 1.5.2. Créer la route de déconnexion

- Dans le controlleur `AuthentificationController`, ajouter une route sur l'url `/deconnexion` nommée `app_deconnexion`.

---

## 1.8. Publication des modifications sur GitHub

### 1.8.1. Critères de réussite/acceptation

#### Inscription

- La page où le formulaire d'inscription est implémenté est navigable.
- Le formulaire s'affiche et possède les champs nécessaires.
- Si l'utilisateur est déjà inscrit, afficher une erreur dans la vue.
- L'inscription fonctionne, l'utilisateur est enregistré dans la base de données avec le mot de passe hashé.
- Afficher un message de réussite, lors de d'une inscription réussie.
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
