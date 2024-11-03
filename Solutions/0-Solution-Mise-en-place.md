# Project Symfony

## 1. Mise en place de l'environnement

### 1.1. Nouveau projet Symfony

#### Commande
```bash
symfony new my_project_directory --version="7.1.*"
```

---

### 1.2. Installer les package de développement:
#### Maker Bundle

```bash
composer require --dev symfony/maker-bundle
```

#### Profiler
```bash
composer require --dev symfony/profiler-pack
```

### 1.3. Installer les package global

#### Doctrine ORM
```bash
composer require orm
```

#### Twig
```bash
composer require twig
```

#### Form
```bash
composer require symfony/form
```

#### Validation
```
composer require symfony/validator
```

#### Authentification
```bash
composer require symfony/security-bundle
```

---

### 1.4. Afficher une page d'accueil

#### 1.4.1. Créer une template de base:
```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        <link rel="icon" href="data:image/svg+xml,<svg  viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
        {% block stylesheets %}
        {% endblock %}

        {% block javascripts %}
        {% endblock %}
    </head>
    <body>
        {% block body %}{% endblock %}
    </body>
</html>

```


#### 1.4.2. Créer une template pour la page d'accueil:
```html
{% extends 'base.html.twig' %}

{% block title %}Portfolio Collaboration{% endblock %}

{% block body %}
<div>
    <h1>Bienvenue sur Portfolio Collaboration! ✅</h1>
</div>
{% endblock %}
```


#### 1.4.3. Créer un contrôleur:
```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
```
### 1.4.4: Tester le fonctionnement de l'application:
Lancez votre application:
```bash
symfony server:start
```
Puis utiliser votre navigateur pour accéder à la page d'accueil de votre application sur [http://localhost:8000](http://localhost:8000)

## 1.5. Mise en place de Github
Rendez-vous sur le [site de Github](https://github.com/):
- Créer un nouveau Projet Guthub.
- Créez un nouveau Repository.
- Lier le Repository avec le projet.
- Inviter et Ajouter le formateur en collaboration.
- Faites un premier push sur le repository:

Initialiser git:
```bash
git init
```

Ajoutez tous les fichiers de l'application:
```bash
git add .
```

Créez un premier commit:
```bash
git commit -m "Mise en place de l'application"
```

Changez de branche:
```bash
git branch -M main
```

Liez le repository locale à github (NOTE: Changer l'url avec votre url):
```bash
git remote add origin URL-DE-VOTRE-REPOSITORY
```

Faites un push sur la branche main:
```bash
git push -u origin main
```