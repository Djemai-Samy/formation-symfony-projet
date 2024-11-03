# 0. Project Symfony: Mise en place de l'environnement

## 1.1. Nouveau projet Symfony

[Suivez la documentation](https://symfony.com/doc/current/setup.html) et créer un nouveau projet symfony.

---

## 1.2. Installer les inbtégrations de développement:
[En suivant la documentation officiel de Symfony](https://symfony.com/bundles), commencez par installer les packages utille pour le dévéloppement de l'application:

### 1.2.1. Maker Bundle:
[MakerBundle](https://symfony.com/bundles/SymfonyMakerBundle/current/index.html) est Package de développement utile pour la creation de composants symfony, craeation et migration de bases de données...

### 1.2.2. Profiler 
[Profiler](https://symfony.com/doc/current/profiler.html) est une pakacge utile pour debugger l'application. Il vous permet d'inscpecter tous les composant de symfony comme les requête et réponses, les formulaires, l'authentification...

---

## 1.3. Installer les integrations nécessaires:
### 1.3.1 Doctrine ORM
[Doctrine ORM](https://symfony.com/doc/current/doctrine.html) est un package qui permet l'interaction avec une base données.

### 1.3.2.Twig
[Twig Bundle](https://symfony.com/components/Twig%20Bundle) est un package qui permet l'interaction avec une base données.

### 1.3.3.Validation
[Validator](https://symfony.com/doc/current/components/validator.html) est un package qui permet de valider des données. Il peut facilement s'utiliser avec Les entité de donctrine et les Formulaire pour validé les données.

### 1.3.4.Form
[Form Component](https://symfony.com/doc/current/components/form.html) est un package pour la création et la gestion de formulaire complexes, tout en s'integrant parfaitement avec les Twig, Doctrine t la Validation de données.

### 1.3.5.Authentification
[Security Bundle](https://symfony.com/doc/current/security.html) est le package qui permet de gérer l'inscription, l'authentification et la session des utilisateurs de l'application.

---

## 1.4. Afficher une page d'accueil
### 1.4.1: Créer une template de base:
Créez un nouveau fichier. (`templates/pages/layout.html.twig`).
Ce fichier s'occupera de charger et d'afficher toutes les parties communes de vos pages, comme les style globaux, les fichier javascript, la barre de navigation, le pied de page...


### 1.4.2: Créer une template pour la page d'accueil. 
Créez un nouveau fichier: (`templates/pages/index.html.twig`).
Cette page sera la page d'accueil du site web, afficher un titre pour le moment.
Plus tard,  vous ajouterai plus de contenu.

### 1.4.3: Créer un contrôleur:
Créez un nouveau fichier: (`Controller/AccueilController.php`)
Ce contrôleur s'occupera d'afficher la page d'accueil pour le moment.
Plus tard, il se chargera de récuperer des données et de les envoyer à la vue. 

### 1.4.4: Tester le fonctionnement de l'application:
Lancez votre apllication puis utiliser votre navigateur pour accéder à la page d'accueil de votre application.

---

## 1.5. Mise en place de la base de données
### 1.5.1. Configuration de labse de données:
Changez la variable `DATABASE_URL` dans le fichier `.env` pour vous connectez à votre base de données.

### 1.5.2. Créer la base de données:
Utiliser la commande de Symfony Maker Bundle pour créer la base de données.

---

## 1.6. Mise en place de Github
Rendez-vous sur le [site de Github](https://github.com/):
- Créer un nouveau Projet Guthub.
- Créez un nouveau Repository.
- Lier le Repository avec le projet.
- Inviter et Ajouter le formateur en collaboration.
- Faites un premier push sur le repository. 
