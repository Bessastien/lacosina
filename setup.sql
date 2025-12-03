-- =====================================================
-- Script de création de la base de données La Cosina
-- =====================================================
-- Description : Création complète de la base de données
--               avec toutes les tables et données initiales
-- Version : 2.0 (TP 1-10 complets)
-- Date : Décembre 2025
-- =====================================================

-- Suppression et création de la base de données (optionnel)
-- DROP DATABASE IF EXISTS `lacosina`;
-- CREATE DATABASE `lacosina` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `lacosina`;

-- =====================================================
-- TABLES
-- =====================================================
-- IMPORTANT : L'ordre de suppression respecte les contraintes de clés étrangères
-- Les tables avec dépendances sont supprimées en premier

-- Suppression des tables avec clés étrangères (dans l'ordre)
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `favoris`;
DROP TABLE IF EXISTS `recettes`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `contacts`;

-- Table contacts
-- Stocke les messages de contact envoyés via le formulaire
CREATE TABLE `contacts` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(100) NOT NULL,
    `prenom` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `message` text NOT NULL,
    `date_creation` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table users
-- Gère les utilisateurs avec authentification sécurisée
-- isAdmin : 1 = administrateur, 0 = utilisateur standard
CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `identifiant` varchar(100) NOT NULL UNIQUE,
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
    `isAdmin` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table recettes
-- Contient toutes les recettes avec leur type et statut de validation
-- type_plat : Catégorie de la recette (Entrée, Plat, Dessert)
-- isApproved : 1 = recette approuvée et visible, 0 = en attente de validation admin
CREATE TABLE `recettes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `titre` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `auteur` varchar(100) NOT NULL,
    `image` varchar(100) DEFAULT NULL,
    `date_creation` datetime NOT NULL,
    `type_plat` enum('Entrée', 'Plat', 'Dessert') DEFAULT 'Plat',
    `isApproved` tinyint(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table favoris
-- Table de liaison entre utilisateurs et recettes favorites
-- Clés étrangères avec suppression en cascade
CREATE TABLE `favoris` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `recette_id` int NOT NULL,
    `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`recette_id`) REFERENCES `recettes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table comments
-- Commentaires sur les recettes avec système de validation
-- isApproved : 0 = en attente de validation, 1 = approuvé et visible
CREATE TABLE `comments` (
    `id` int NOT NULL AUTO_INCREMENT,
    `recette_id` int NOT NULL,
    `pseudo` varchar(100) NOT NULL,
    `commentaire` text NOT NULL,
    `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
    `isApproved` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`recette_id`) REFERENCES `recettes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- =====================================================
-- DONNÉES INITIALES
-- =====================================================

-- Insertion des utilisateurs par défaut
-- Admin: identifiant=admin, mdp=azerty, email=contact@lacosina.fr (admin)
-- Robert: identifiant=robert, mdp=roro87, email=robert@jmail.com (user)
INSERT INTO `users` (identifiant, email, password, isAdmin, date_creation) VALUES
('admin', 'contact@lacosina.fr', '$2y$10$oap9mQC1bvdQWADq91qtO./k7wncgOT74gtMvuI1mHeeib31ssWke', 1, NOW()),
('robert', 'robert@jmail.com', '$2y$10$Ha3lFuqwcOU7xaq2hAh92.QjVn.RHV0SjpDNqyZf.JRElz0y4gd7e', 0, NOW());

-- Insertion des recettes initiales
-- 4 recettes traditionnelles : 2 entrées, 1 plat, 1 dessert
-- Toutes sont pré-approuvées (isApproved = 1)
INSERT INTO `recettes` (titre, description, auteur, image, date_creation, type_plat, isApproved) VALUES
('Treipas', 'Le Treipas est une spécialité pâtissière du Limousin créé par un groupement de pâtissiers locaux. Il est composé de trois textures et de trois parfums : un fond de feuilletine, une mousse aux châtaignes, une mousse au chocolat noir, un biscuit à la noisette et un glaçage au chocolat, surmonté d\'un marron glacé et de deux feuilles vertes en pâte d\'amandes.', 'contact@lacosina.fr', 'images/Treipais.jpg', NOW(), 'Dessert', 1),
('Confit de canard', 'La viande est cuite pendant au moins 2 h dans la graisse chaude, entre 70 et 85 °C, puis mise en bocaux et recouverte de graisse, de telle sorte que l\'air ne puisse pas entrer en contact avec elle et la détériorer.', 'contact@lacosina.fr', 'images/Confit_canard.jpg', NOW(), 'Plat', 1),
('Soupe au pistou', 'La soupe au pistou (sopa au psto, soupo au pstou) est une soupe aux légumes d\'été, avec des pâtes, servie avec du pistou, un mélange d\'ail, d\'huile d\'olive et de basilic haché. Le terme pistou désigne, en provençal, le pilon du mortier qui sert à faire la préparation, et non pas le basilic qui se dit baseli.', 'contact@lacosina.fr', 'images/Pistou.jpg', NOW(), 'Entrée', 1),
('Tapenade', 'La tapenade (tapenada, tapenado) est une recette de cuisine provençale, mise au point en 1880 par un chef-cuisinier de Marseille. Elle est principalement constituée d\'olives broyées, d\'anchois, de thon marin, d\'herbes et de câpres (tapena en occitan, d\'où son nom).', 'contact@lacosina.fr', 'images/Tapenade.jpg', NOW(), 'Entrée', 1);

-- =====================================================
-- FIN DU SCRIPT
-- =====================================================
-- La base de données La Cosina est maintenant prête à l'emploi !
-- Comptes créés :
--   - Admin : admin / azerty (email: contact@lacosina.fr)
--   - User  : robert / roro87 (email: robert@jmail.com)
-- =====================================================

