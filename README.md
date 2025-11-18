# La Cosina - Projet PHP MVC

## Description
La Cosina est un site de gestion de recettes développé en PHP utilisant le pattern MVC (Model-View-Controller). Le site permet de consulter des recettes, d'en ajouter, de contacter l'équipe, de s'inscrire/se connecter, de gérer des favoris et d'ajouter des commentaires.

## Fonctionnalités

### TP01 - Structure de base
- ✅ Création de la base de données `lacosina`
- ✅ Création de la structure du projet (models, controllers, views)
- ✅ Configuration de la connexion PDO

### TP02 - Recettes et Contacts
- ✅ Table `recettes` (id, titre, description, auteur, date_creation)
- ✅ Table `contacts` (id, nom, prenom, email, message, date_creation)
- ✅ Formulaires d'ajout pour recettes et contacts
- ✅ Sauvegarde en base de données
- ✅ Envoi d'emails pour les messages de contact

### TP03 - Refactorisation et Recettes Initiales
- ✅ Organisation des vues par entité (Recette, Contact, User)
- ✅ Création de classes Controllers (RecetteController, ContactController, UserController)
- ✅ Routeur double paramètre (c=Entité&a=action)
- ✅ Insertion des 4 recettes initiales :
  - Treipas
  - Confit de canard
  - Soupe au pistou
  - Tapenade

### TP04 - Détail des recettes et Styling
- ✅ Page de détail des recettes
- ✅ Cartes Bootstrap responsive
- ✅ JavaScript pour rendre les cartes cliquables
- ✅ Styling CSS personnalisé
- ✅ Mise en page avec w-75 et m-auto

### TP05 - Authentification
- ✅ Table `users` (id, email, password, identifiant)
- ✅ Formulaire d'inscription
- ✅ Formulaire de connexion
- ✅ Hashage des mots de passe avec password_hash()
- ✅ Gestion des sessions
- ✅ Menu avec boutons Inscription/Connexion
- ✅ Affichage de l'identifiant après connexion

### TP06 - Système de Favoris
- ✅ Table `favoris` avec clés étrangères
- ✅ Modèle Favori.php
- ✅ Contrôleur FavoriController.php
- ✅ Bouton "Ajouter aux favoris" / "Retirer des favoris" dans la page détail
- ✅ Vérification des doublons
- ✅ Menu "Mes recettes favorites" dans le profil utilisateur
- ✅ Affichage des favoris en JSON via fetch API
- ✅ Gestion de la variable x pour affichage JSON uniquement
- ✅ Icônes de cœur (vide/rempli) sur la liste des recettes
- ✅ Icônes Bootstrap pour modifier/supprimer (admin)
- ✅ Système de messages flash (succès/erreur)

### TP07 - Système de Commentaires
- ✅ Table `comments` avec clés étrangères
- ✅ Modèle Commentaire.php
- ✅ Contrôleur CommentaireController.php
- ✅ Affichage des commentaires dans la page détail
- ✅ Formulaire d'ajout de commentaire dynamique (JavaScript)
- ✅ Commentaires anonymes ou avec identifiant utilisateur
- ✅ Gestion de l'admin (champ isAdmin dans users)
- ✅ Menu "Liste des commentaires" pour l'administrateur
- ✅ Suppression de commentaires (modération admin)
- ✅ Suppression en cascade (recette → favoris + commentaires)
- ✅ Message d'erreur pour les pages non trouvées

## Structure du Projet

```
lacosina/
├── controllers/
│   ├── RecetteController.php
│   ├── ContactController.php
│   ├── UserController.php
│   ├── FavoriController.php
│   └── CommentaireController.php
│   ├── ContactController.php
│   └── UserController.php
├── models/
│   ├── connectDb.php
│   ├── Recette.php
│   ├── Contact.php
│   └── User.php
├── views/
│   ├── header.php
│   ├── footer.php
│   ├── Recette/
│   │   ├── accueil.php
│   │   ├── ajout.php
│   │   ├── enregistrer.php
│   │   ├── liste.php
│   │   └── detail.php
│   ├── Contact/
│   │   ├── ajout.php
│   │   └── enregistrer.php
│   ├── User/
│   │   ├── inscription.php
│   │   ├── connexion.php
│   │   └── enregistrement.php
│   └── js/
│       └── front.js
├── css/
│   └── style.css
└── index.php
```

## Installation et Configuration

### Prérequis
- PHP 7.4+
- MySQL 5.7+
- Serveur web (Apache, Nginx, etc.)

### Étapes d'installation

1. **Placer le projet** dans le répertoire web (`htdocs` ou `www`)

2. **Créer la base de données** :
   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS lacosina;"
   ```

3. **Créer les tables** :
   ```bash
   mysql -u root lacosina < setup.sql
   ```

4. **Accéder au site** :
   ```
   http://localhost/lacosina/
   ```

## Utilisation

### Navigation
- **Accueil** : Page de bienvenue
- **Recettes** : Liste de toutes les recettes
- **Ajouter une recette** : Formulaire pour ajouter une recette (accessible après connexion)
- **Contact** : Formulaire de contact
- **Inscription/Connexion** : Authentification utilisateur

### Routes
Les routes utilisent le format : `?c=Contrôleur&a=action&id=paramètre`

Exemples :
- `?c=Recette&a=lister` : Affiche la liste des recettes
- `?c=Recette&a=detail&id=1` : Affiche le détail de la recette 1
- `?c=User&a=inscription` : Formulaire d'inscription
- `?c=User&a=connexion` : Formulaire de connexion

## Technologie

- **Backend** : PHP (PDO pour la base de données)
- **Frontend** : Bootstrap 5.3, HTML5, CSS3, JavaScript
- **Database** : MySQL

## Auteur
Développé dans le cadre du cours R3.01 PHP - IUT
Sébastien DABERT

## Licence
MIT

