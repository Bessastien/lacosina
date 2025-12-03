# La Cosina - Site de Recettes Traditionnelles

## 📖 Description
La Cosina est une application web de gestion de recettes traditionnelles développée en PHP avec l'architecture MVC (Model-View-Controller). Le projet permet la consultation, l'ajout et la gestion de recettes culinaires avec un système d'authentification, de favoris, de commentaires et de validation administrative.

## ✨ Fonctionnalités

### Fonctionnalités de base (TP 1-7)
- ✅ Architecture MVC complète avec routage
- ✅ CRUD complet des recettes
- ✅ Système d'authentification sécurisé (hashage de mots de passe)
- ✅ Gestion des favoris par utilisateur
- ✅ Système de commentaires sur les recettes
- ✅ Formulaire de contact

### TP 8 - Architecture et Filtrage
- ✅ **Composer et PSR-4** : Autoloader automatique pour les classes
- ✅ **Type de plat** : Catégorisation des recettes (Entrée, Plat, Dessert)
- ✅ **Filtrage AJAX** : Filtres dynamiques par type de plat sans rechargement de page
- ✅ **Workflow de validation** : Système d'approbation des recettes

### TP 9 - Recherche et Logs
- ✅ **Barre de recherche** : Recherche en temps réel dans le header
- ✅ **API JSON** : Endpoints de recherche et de filtrage
- ✅ **Monolog** : Journalisation des connexions et actions importantes

### TP 10 - Workflow de validation
- ✅ **Validation des recettes** : Les recettes des utilisateurs nécessitent une approbation admin
- ✅ **Validation des commentaires** : Tous les commentaires nécessitent une approbation
- ✅ **Interface admin** : Pages dédiées pour valider recettes et commentaires
- ✅ **Badges de notification** : Compteurs d'éléments en attente dans le menu admin

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx) ou PHP built-in server
- Composer (optionnel pour les logs)

### Étapes d'installation

1. **Cloner ou télécharger le projet**
   ```bash
   cd C:\gDrive\Etude\IUT\S3\R3.01-php\lacosina
   ```

2. **Créer la base de données**
   ```sql
   mysql -u root -p
   CREATE DATABASE lacosina CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE lacosina;
   source setup.sql;
   exit;
   ```

   **Ou via phpMyAdmin :**
   - Créer une base `lacosina`
   - Importer le fichier `setup.sql`

3. **Configurer la connexion** (si nécessaire)
   
   Éditer `models/connectDb.php` :
   ```php
   $host = "localhost";
   $dbname = "lacosina";
   $user = "root";
   $password = "";
   ```

4. **Installer Composer (optionnel mais recommandé)**
   ```bash
   composer install
   ```
   Cela installera Monolog pour la journalisation des événements.

5. **Lancer le serveur**
   ```bash
   php -S localhost:8000
   ```
   
   Puis ouvrir : http://localhost:8000

## 👤 Comptes par défaut

Deux utilisateurs sont créés automatiquement :

### Administrateur
- **Identifiant** : `admin`
- **Mot de passe** : `azerty`
- **Email** : contact@lacosina.fr

### Utilisateur standard
- **Identifiant** : `robert`
- **Mot de passe** : `roro87`
- **Email** : robert@jmail.com

## 📂 Structure du projet

```
lacosina/
├── controllers/          # Contrôleurs MVC
│   ├── RecetteController.php
│   ├── UserController.php
│   ├── CommentaireController.php
│   ├── FavoriController.php
│   └── ContactController.php
├── models/              # Modèles de données
│   ├── Recette.php
│   ├── User.php
│   ├── Commentaire.php
│   ├── Favori.php
│   ├── Contact.php
│   └── connectDb.php
├── views/               # Vues
│   ├── header.php
│   ├── footer.php
│   ├── Recette/        # Liste, détail, ajout, etc.
│   ├── User/           # Connexion, profil, etc.
│   ├── Commentaire/    # Gestion des commentaires
│   └── Contact/        # Formulaire de contact
├── css/                 # Styles CSS
├── images/              # Images des recettes
├── logs/                # Fichiers de logs (app.log)
├── composer.json        # Configuration Composer
├── index.php           # Point d'entrée
├── setup.sql           # Script de création BDD
└── migration.sql       # Script de migration (BDD existante)
```

## 🎯 Utilisation

### Navigation principale

#### Visiteur (non connecté)
- Consulter la liste des recettes
- Voir le détail d'une recette
- Rechercher des recettes
- Filtrer par type de plat
- Contacter l'équipe
- S'inscrire / Se connecter

#### Utilisateur connecté
- Toutes les fonctionnalités visiteur
- Proposer des recettes (soumises à validation)
- Ajouter des recettes aux favoris
- Voir ses favoris
- Commenter (soumis à validation)
- Gérer son profil

#### Administrateur
- Toutes les fonctionnalités utilisateur
- Publier des recettes immédiatement
- Modifier toutes les recettes
- Supprimer toutes les recettes
- Valider les recettes en attente (badge de notification)
- Valider les commentaires en attente (badge de notification)
- Gérer tous les commentaires

### Fonctionnalités avancées

#### Recherche dynamique
1. Cliquer sur la barre de recherche dans le header
2. Taper au moins 2 caractères
3. Les résultats s'affichent instantanément
4. Cliquer sur un résultat pour accéder à la recette

#### Filtrage par type
1. Sur la page "Recettes", utiliser les boutons de filtre
2. **Tous** : Affiche toutes les recettes
3. **Entrées** / **Plats** / **Desserts** : Filtre par catégorie
4. La liste se met à jour sans rechargement

#### Workflow de validation (Admin)
1. Se connecter en tant qu'admin
2. Observer les badges de notification dans le menu
3. Cliquer sur "Recettes à valider" ou "Commentaires à valider"
4. Approuver ou supprimer les éléments en attente

## 🔧 Migration depuis une version antérieure

Si vous avez déjà une base de données existante :

```sql
mysql -u root -p lacosina < migration.sql
```

Cela ajoutera les colonnes `type_plat` et `isApproved` nécessaires.

## 🔒 Sécurité

Le projet implémente les bonnes pratiques de sécurité :

- ✅ **PDO avec requêtes préparées** : Protection contre les injections SQL
- ✅ **htmlspecialchars()** : Protection contre les attaques XSS
- ✅ **password_hash()** : Hashage sécurisé des mots de passe
- ✅ **Vérification des droits** : Contrôle d'accès pour les actions sensibles
- ✅ **Sessions sécurisées** : Gestion de l'authentification

## 📊 Base de données

### Tables principales

- **recettes** : Recettes avec type, auteur, image, statut d'approbation
- **users** : Utilisateurs avec identifiant, email, mot de passe hashé, rôle admin
- **comments** : Commentaires avec statut d'approbation
- **favoris** : Relations utilisateur-recette
- **contacts** : Messages de contact

### Schéma relationnel

```
users (1) ----< (N) favoris (N) >---- (1) recettes
                                          |
                                          | (1)
                                          |
                                          v
                                        (N) comments
```

## 🛠️ Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL 5.7+
- **Frontend** : HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS** : Bootstrap 5.3
- **Icônes** : Bootstrap Icons
- **AJAX** : Fetch API
- **Logs** : Monolog (via Composer)
- **Architecture** : MVC

## 📝 API Endpoints

### Recherche
```
GET ?c=Recette&a=recherche&q=terme
Retourne : JSON array des recettes correspondantes
```

### Filtrage
```
GET ?c=Recette&a=lister&ajax=1&type_plat=Entrée
Retourne : JSON array des recettes filtrées
```

## 🐛 Dépannage

### Erreur "colonne type_plat n'existe pas"
→ Exécuter le script `migration.sql` sur votre base existante

### Les logs ne sont pas créés
→ Installer Composer : `composer install`
→ Vérifier que le dossier `logs/` existe et est accessible en écriture

### La recherche ne fonctionne pas
→ Vérifier que JavaScript est activé dans le navigateur
→ Ouvrir la console (F12) pour voir les erreurs

### Erreur de connexion à la base
→ Vérifier que MySQL est démarré
→ Vérifier les paramètres dans `models/connectDb.php`
→ Vérifier que la base `lacosina` existe

## 📚 Documentation complémentaire

- **README_COMPLET.md** : Documentation technique détaillée
- **setup.sql** : Script complet de création de la base
- **migration.sql** : Script de migration pour bases existantes
- **test_database.sql** : Script de test de la base de données

## 🎓 Projet pédagogique

Ce projet a été réalisé dans le cadre des travaux pratiques R3.01-php - IUT S3, couvrant les thématiques suivantes :

- Architecture MVC
- Gestion de bases de données relationnelles
- Sécurité des applications web
- AJAX et APIs JSON
- Composer et autoloading PSR-4
- Intégration de librairies tierces
- Workflow métier et validation

## 📄 License

Projet à usage éducatif - IUT S3

---

**Auteur** : Projet La Cosina - R3.01-php  
**Date** : Décembre 2025  
**Version** : 2.0 (TP 1-10 complets)

