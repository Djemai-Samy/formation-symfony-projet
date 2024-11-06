# 3. Projet Symfony : Portfolio

## NOTE :

- Sur GitHub, créer une nouvelle *Issue*.
- Sur votre ordinateur, créer la branche `feature/portfolio`.

---

## 3.1. Création de l'entité `Collection`

### 3.1.1. Définition de l'entité `Collection`

Créer une entité `Collection` avec les attributs suivants :

- id : entier, unique, autogénéré
- titre : string, obligatoire, min : 3, max : 100
- description : string, non obligatoire, max : 500
- isPublic : booléen, par défaut `false`
- date : datetime, autogénérée lors de la création
- cover : string, peut être nul (chemin de l'image)
- tags : tableau, peut être vide
- catégorie : string, non obligatoire, max : 50

### 3.1.2. Création du Repository

Créer un `CollectionRepository` qui contient la méthode `sauvegarder` pour enregistrer une collection dans la base de données.

### 3.1.3. Effectuer une migration

- Utiliser les commandes de Symfony pour créer et exécuter la migration.
- Vérifier que la migration a bien été appliquée sur la base de données.

---

## 3.2. Création du formulaire de collection

### 3.2.1. Définition du formulaire

Créer une classe de formulaire pour `Collection` qui contient les champs :

- titre : obligatoire, min : 3, max : 100
- description : non obligatoire, max : 500
- isPublic : checkbox (public/privé)
- cover : champ de type fichier, non obligatoire
- tags : champ de texte, séparés par des virgules
- catégorie : champ de type texte, non obligatoire, max : 50

### 3.2.2. Affichage du formulaire

Dans le contrôleur `CollectionController`, ajouter une route `app_ajouter_collection` sur l'URL `/collection/ajouter` :

- Vérifier que l'utilisateur est authentifié, sinon le rediriger vers la page de connexion.
- Créer le formulaire et l'envoyer à la vue `templates/collection/ajouter.html.twig`.
- Afficher et personnaliser le formulaire dans le fichier Twig.

### 3.2.3. Traitement du formulaire

Traiter la soumission du formulaire :

- Vérifier si le formulaire est valide.
- Si un fichier de couverture est soumis, le sauvegarder.
- Enregistrer la collection dans la base de données.
- Rediriger l'utilisateur vers la page de profil avec un message de réussite.

---

## 3.3. Modification d'une collection

### 3.3.1. Création du formulaire de modification

- Ajouter une route `app_modifier_collection` sur l'URL `/collection/{id}/modifier`.
- Charger l'entité `Collection` depuis la base de données en utilisant l'identifiant.
- Pré-remplir le formulaire avec les données existantes de la collection.
- Afficher le formulaire sur la page `templates/collection/modifier.html.twig`.

### 3.3.2. Traitement du formulaire de modification

Traiter les données soumises :

- Si le formulaire est valide, enregistrer les modifications.
- Si un nouveau fichier de couverture est soumis, le sauvegarder et mettre à jour l'entité `Collection`.
- Rediriger l'utilisateur vers la page de la collection avec un message de réussite.

---

## 3.4. Suppression d'une collection

### 3.4.1. Création de la route de suppression

Dans `CollectionController`, ajouter une route `app_supprimer_collection` sur l'URL `/collection/{id}/supprimer` :

- Vérifier que l'utilisateur est authentifié.
- Charger la collection et la supprimer de la base de données.
- Rediriger l'utilisateur vers la page de profil avec un message de confirmation.

---

## 3.5. Création de l'entité `Post`

### 3.5.1. Définition de l'entité `Post`

Créer une entité `Post` avec les attributs suivants :

- id : entier, unique, autogénéré
- titre : string, obligatoire, min : 3, max : 100
- description : string, non obligatoire, max : 1000
- date : datetime, autogénérée lors de la création
- image : string, peut être nul (chemin de l'image)
- isPublic : booléen, par défaut `false`
- collection : relation ManyToOne vers `Collection`

### 3.5.2. Création du Repository

Créer un `PostRepository` avec la méthode `sauvegarder` pour enregistrer un post.

### 3.5.3. Effectuer une migration

- Créer et exécuter la migration pour l'entité `Post`.
- Vérifier l'application de la migration.

---

## 3.6. Gestion des posts

### 3.6.1. Création du formulaire de post

Créer une classe de formulaire pour `Post` avec les champs :

- titre : obligatoire, min : 3, max : 100
- description : non obligatoire, max : 1000
- image : champ de type fichier, non obligatoire
- isPublic : checkbox (public/privé)

### 3.6.2. Ajout d'un post

Dans le contrôleur `PostController`, ajouter une route `app_ajouter_post` sur l'URL `/collection/{id}/post/ajouter` :

- Vérifier que l'utilisateur est authentifié.
- Afficher le formulaire sur la page `templates/post/ajouter.html.twig`.
- Traiter la soumission et enregistrer le post.

### 3.6.3. Modification et suppression d'un post

- Route `app_modifier_post` sur `/post/{id}/modifier` : traiter et afficher le formulaire pour modifier un post.
- Route `app_supprimer_post` sur `/post/{id}/supprimer` : supprimer le post et rediriger avec un message de confirmation.

---

## 3.7. Affichage des collections et des posts

### 3.7.1. Page de profil

- Modifier `templates/pages/profile/index.html.twig` pour afficher les collections sous forme de cartes.
- Chaque carte doit montrer le titre, la description et l'image de couverture de la collection.
- Ajouter un bouton pour accéder à la page de détail de chaque collection.

### 3.7.2. Page de collection

- Créer une route `app_detail_collection` sur `/collection/{id}`.
- Afficher les informations de la collection et la liste des posts associés.

---

## 3.8. Publication sur GitHub

### 3.8.1. Critères de réussite/acceptation

#### Création et gestion des collections

- Les collections peuvent être ajoutées, modifiées et supprimées.
- Les données sont sauvegardées dans la base et respectent les validations.

#### Création et gestion des posts

- Les posts peuvent être ajoutés, modifiés et supprimés.
- Les images de posts sont bien traitées et sauvegardées.

#### Affichage et navigation

- Les collections s'affichent correctement sous forme de cartes.
- Les utilisateurs peuvent naviguer vers la page d'une collection pour voir les détails et les posts.

### Publication sur GitHub

- Committer le code avec un message descriptif.
- Publier sur le repository GitHub.
- Créer une pull request et notifier le formateur.