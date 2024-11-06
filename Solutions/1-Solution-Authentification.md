# 1. Project Symfony: Authentification

## 1.1. Configuration des utilisateur

### 1.1.1. : Création de l'entité utilisateurs

#### 1.1.1.1. Classe de base

Créer l'entité qui representera l'utilisateur.
L'entité possèdera les propriétés suivantes ainsi que le accesseurs et mutateurs:

- id: entier, unique, auto généré
- email: string, unique
- password: string
- pseudo: string
- avatar: string, peut etre null.
- roles: Tableau

#### 1.1.1.2. Implementation de l'insterface `UserInterface`

Ajouter l'impléméntation de l'interface: `UserInterface`, ainsi que le propriétés et methodes nécéssaires.

#### 1.1.1.3. Implementation de l'insterface pour le mot de passe

Ajouter l'impléméntation de l'interface: `PasswordAuthenticatedUserInterface`, ainsi que le propriétés et methodes nécéssaires.

```php
<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(length: 180, nullable: false)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 180)]
    private ?string $avatar = null;

    /**
     * @var list<string> ROle des utilisateurs
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string Mot de passe hashé
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Identifiant visuel de l'utilisateur
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // L'utilisateur possède au moins un role
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // Si vous stockez temporairment des données sensible, effacez les
        // $this->plainPassword = null;
    }
}
```

---

### 1.1.2. : Création du Repository

- Créer le fichier `UtilisateurRepository`.
- Créer la classe `UtilisateurRepository` qui hérite de `ServiceEntityRepository `.
- Impélémenter le constructeur en injectant le Service `ServiceEntityRepository ` , est instanciant la classe parent.
- Implémenter la methode `sauvegarder` qui permet d'enregistrer l'utilisateur dans la base de données.
```php
<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function sauvegarder(Utilisateur $user): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}

```
---

### 1.1.3. : Effectuer une migration

- Utiliser les commande de symfony pour créer et executer un migration.
- Vérifier que la migration a bien était effectuer sur vote base de données.

```bash
php bin/console make:migration
```

```bash
php bin/console doctrine:migrations:migrate
```
---
