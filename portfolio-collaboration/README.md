# DORANCO - Project Symfony

## 1. Mode Développement:

### 1.1. Décplacez vou ssur le dossier de l'application
```bash
cd ./portfolio-collaboration
```

### 1.2. Installer les pakacges nécéssaires:

```bash
composer install
```

### 1.3. Changer la configuration de la base donées:
Dans le ficher `.env`, mettez à jour la variable d'environement:
```bash
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```

### 1.4. Créer la base de données:
Si vous n'avez pas crée la base données:
```bash
symfony console doctrine:database:create
```

### 1.5. Migrations de la base données
Si vos tables ne sont pas à jour:
```bash
php bin/console make:migration
```

```bash
php bin/console doctrine:migrations:migrate
```

### 1.6. Lancer l'application en mode developpment

```bash
symfony server:start
```