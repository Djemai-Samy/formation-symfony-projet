# 5. Projet Symfony : Commentaires

## NOTE :

- Sur GitHub, créer une nouvelle _Issue_.
- Sur votre ordinateur, créer la branche `feature/commentaires`.

---

## 5.1. Commentaires

### 5.1..1 Entité et Repository

Créer un entitié `Commentaires` avec les champs:

- id,
- contenu,
- date,
- user: relation ManyToOne (Mettre à jour l'entité `Utilisateur` avec la nouvelle relation).
- collection: relation ManyToOne (Mettre à jour l'entité `Collection` avec la nouvelle relation).

Créer le Repository pour l'entité `Commentaire`.

Faites une migration sur la base de données.

---

### 5.1.2. Publier un commentaire

Dans la page de détaille d'une collection.

- Ajoutez la fonctionnalité permettant a l'utilisateur d'ajouter un commentaire sur la collection.

---

### 5.1.3. Afficher les commentaire dans la collection:

Afficher tous les commentaires de la collection, ordonnéees du plus récent au plus ancien.
Un commentaire doit afficher:

- L'utilisateur qui a publié le commentaire (Un lien vers page de profile).
- Le contenu du commentaire
- La date de publication du commentaire.

### 5.1.4.. Suppression des commentaires:

Ajoutez la fonctionnalité permettant à l'utilisateur de supprimer un commentaire publié par lui.

### 5.1.5. Afficher les commentaire de l'utlisateur:

Sur la page de profile de l'utilisateur ajoutez un lien '/commentaires' vers une page qui affichera tous les commentaire de l'utilisateur.

Sur la pages des commentaires:

- Afficher tous les commentaires de l'utilisateur (20 par pages).
- Les commentaires doivent affiché le contenu, la date, et le lien vers la collection commentée.

---

## 5.2. Les likes

### 5.2.1. Modifier les entités

Dans l'entité Post:

- Ajouter une relation ManyToMany nommée "utilisateurLikes".

Dans l'entité Utilisateur:

- Ajouter une relation ManyToMany nomée "postLikes"

---

### 5.2.2. Ajouter ou supprimer un like

Ajouter un bouton sur caque carte de post, afin que les utilisateurs puissent ajouter ou supprimer un like.

---

D'accord, voici une version modifiée de la section 5.3 avec des critères d'acceptation plus pertinents pour le projet sur les commentaires et les likes.

---

## 5.3. Publication sur GitHub

### Critères d'acceptation

Pour la fonctionnalité des commentaires et des likes, les critères d'acceptation sont les suivants :

#### **Commentaires**

- L'utilisateur doit pouvoir publier un commentaire sur la page de détail d'une collection.
- Les commentaires publiés doivent s'afficher immédiatement, ordonnés du plus récent au plus ancien.
- Chaque commentaire doit afficher l'auteur (avec un lien vers la page de profil), le contenu et la date de publication.
- L'utilisateur doit pouvoir supprimer ses propres commentaires.

#### **Page de profil - Commentaires**

- La page de profil de l'utilisateur doit contenir un lien vers une section `/commentaires`, où tous les commentaires publiés par l'utilisateur sont listés (20 commentaires par page).
- Chaque commentaire sur la page de l'utilisateur doit afficher le contenu, la date, et un lien vers la collection correspondante.

#### **Likes**

- Les utilisateurs doivent pouvoir ajouter et retirer un like sur chaque post.
- Le nombre total de likes doit être visible sur chaque carte de post.
- La fonctionnalité doit être interactive, avec une mise à jour immédiate lors de l'ajout ou du retrait d'un like.

### Publication sur GitHub

- Le code doit être commité avec un message descriptif mentionnant les modifications ou fonctionnalités ajoutées.
- Le code doit être publié sur le dépôt GitHub de manière propre et structurée.
- Une pull request doit être créée, et le formateur doit être notifié pour la révision.
