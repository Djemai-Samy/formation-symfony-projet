
### 1.3.4. Flash Message : (BONUS : Niveau 1)

Maintenant que les utilisateurs peuvent s'inscrire, nous allons leur afficher un message lors d'une inscription réussie ou échouée en utilisant les [Flash Messages de la Session de Symfony](https://symfony.com/doc/current/session.html#flash-messages) au lieu des queries.

Commencez par lire la documentation sur les sessions [Documentation sur la Session de Symfony](https://symfony.com/doc/current/session.html).

Dans la Route `app_authentification_page`, lors du test de l'existence de l'utilisateur :

- Ajoutez un Flash message nommé `inscription` contenant un tableau associatif avec :
  - la clé `status` avec la valeur `'error'`
  - la clé `message` avec la valeur `'UTILISATEUR_EXISTE'`

- Ajoutez un Flash message lors d'une inscription réussie :
  - la clé `status` avec la valeur `'success'`
  - la clé `message` avec la valeur `'INSCRIPTION_REUSSIE'`

Dans le template Twig `templates/pages/authentification/index.html.twig` :
  - Afficher les messages en les récupérant des flashs.