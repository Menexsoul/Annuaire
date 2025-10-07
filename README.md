# 🏆 Annuaire Sportif C'Chartres

> Application web développée avec Symfony --- permettant de consulter et
> de gérer les joueurs d'un club sportif, d'attribuer des avis, et
> d'administrer le contenu.

## 📋 Sommaire

1.  Présentation du projet
2.  Objectifs pédagogiques
3.  Technologies utilisées
4.  Installation du projet
5.  Configuration de la base de données
6.  Chargement des données de test (Fixtures)
7.  Lancement du serveur Symfony
8.  Utilisation du site
9.  Sécurité et rôles utilisateurs
10. Structure du projet
11. Comptes de test
12. Améliorations possibles

## 💡 Présentation du projet

**Annuaire Sportif C'Chartres** est une application Symfony permettant
: - de consulter les joueurs d'un club (catégorie, niveau, photo,
etc.), - de laisser des avis (note et commentaire), - et pour les
administrateurs, de gérer le contenu du site via une interface CRUD.

## 🎓 Objectifs pédagogiques

-   Comprendre l'architecture MVC de Symfony.
-   Manipuler les entités Doctrine et les relations entre tables.
-   Implémenter un système d'authentification sécurisé (login /
    register).
-   Gérer des rôles utilisateurs (USER / ADMIN).
-   Mettre en place un CRUD complet côté administrateur.
-   Créer une interface utilisateur claire et fonctionnelle.
-   Utiliser les formulaires et la validation Symfony.

## ⚙️ Technologies utilisées

  Technologie               Description
  ------------------------- -------------------------------
  Symfony 6                 Framework PHP principal
  Doctrine ORM              Gestion de la base de données
  Twig                      Moteur de templates
  MariaDB / MySQL           Système de base de données
  Bootstrap 5 (optionnel)   Mise en forme rapide
  PHP 8.2+                  Version recommandée
  Composer                  Gestionnaire de dépendances

## 🛠️ Installation du projet

``` bash
git clone https://github.com/votre-compte/annuaire-sportif-cchartres.git
cd annuaire-sportif-cchartres
composer install
cp .env.example .env
```

Modifie la ligne suivante dans `.env` :

    DATABASE_URL="mysql://DIO:P@ssw0rd@127.0.0.1:3306/cchartres?serverVersion=10.11.2-MariaDB&charset=utf8mb4"

## 🧱 Configuration de la base de données

``` bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## 🧩 Chargement des données de test (Fixtures)

``` bash
php bin/console doctrine:fixtures:load
```

## 🚀 Lancement du serveur Symfony

``` bash
symfony server:start
```

> Site accessible sur : <http://127.0.0.1:8000>

## 🌐 Utilisation du site

### Page d'accueil

Affiche tous les joueurs avec leurs informations (nom, catégorie,
niveau, photo).

### Fiche joueur

Affiche les détails du joueur, la moyenne des notes et les avis des
utilisateurs. Formulaire d'avis visible uniquement pour les utilisateurs
connectés.

### Connexion / Inscription

-   `/login` : Connexion utilisateur
-   `/register` : Création d'un compte

### Système d'avis

Chaque utilisateur connecté peut noter un joueur (1 à 5 étoiles) et
laisser un commentaire. Une contrainte empêche plusieurs avis sur le
même joueur par un même utilisateur.


## 🔒 Sécurité et rôles utilisateurs

  Rôle         Description
  ------------ -------------------------------------------
  ROLE_USER    Consulter les joueurs et laisser des avis
  ROLE_ADMIN   Accéder et gérer le contenu du site

## 🧬 Structure du projet

    src/
     ├── Controller/
     ├── Entity/
     ├── Form/
     ├── Repository/
     └── DataFixtures/

## 👥 Comptes de test

  Type          Email               Mot de passe   Rôle
  ------------- ------------------- -------------- ------------
  Admin         admin@chartres.fr   Admin123!      ROLE_ADMIN
  Utilisateur   user@chartres.fr    User123!       ROLE_USER


## 📎 Auteur

Projet réalisé par **Thomas Debroize**\
BTS SIO - Option SLAM\
📍 Lycée Fulbert, Chartres
