-- Création de la base de données La Cosina

-- Table contacts
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `nom` varchar(100) NOT NULL,
                            `prenom` varchar(100) NOT NULL,
                            `email` varchar(100) NOT NULL,
                            `message` text NOT NULL,
                            `date_creation` datetime NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table recettes
DROP TABLE IF EXISTS `recettes`;
CREATE TABLE `recettes` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `titre` varchar(100) NOT NULL,
                            `description` text NOT NULL,
                            `auteur` varchar(100) NOT NULL,
                            `image` varchar(100) DEFAULT NULL,
                            `date_creation` datetime NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `identifiant` varchar(100) NOT NULL UNIQUE,
                         `email` varchar(100) NOT NULL UNIQUE,
                         `password` varchar(255) NOT NULL,
                         `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
                         `isAdmin` tinyint(1) DEFAULT 0,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table favoris
DROP TABLE IF EXISTS `favoris`;
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
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `recette_id` int NOT NULL,
                            `pseudo` varchar(100) NOT NULL,
                            `commentaire` text NOT NULL,
                            `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`),
                            FOREIGN KEY (`recette_id`) REFERENCES `recettes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insertion des utilisateurs par défaut
-- Admin: identifiant=admin, mdp=azerty, email=contact@lacosina.fr (admin)
-- Robert: identifiant=robert, mdp=roro87, email=robert@jmail.com (user)
INSERT INTO `users` (identifiant, email, password, isAdmin, date_creation) VALUES
('admin', 'contact@lacosina.fr', '$2y$10$oap9mQC1bvdQWADq91qtO./k7wncgOT74gtMvuI1mHeeib31ssWke', 1, NOW()),
('robert', 'robert@jmail.com', '$2y$10$Ha3lFuqwcOU7xaq2hAh92.QjVn.RHV0SjpDNqyZf.JRElz0y4gd7e', 0, NOW());

-- Insertion des recettes initiales
INSERT INTO `recettes` (titre, description, auteur, image, date_creation) VALUES
('Treipas', 'Le Treipas est une spécialité pâtissière du Limousin créé par un groupement de pâtissiers locaux. Il est composé de trois textures et de trois parfums : un fond de feuilletine, une mousse aux châtaignes, une mousse au chocolat noir, un biscuit à la noisette et un glaçage au chocolat, surmonté d\'un marron glacé et de deux feuilles vertes en pâte d\'amandes.', 'contact@lacosina.fr', 'images/Treipais.jpg', NOW()),
('Confit de canard', 'La viande est cuite pendant au moins 2 h dans la graisse chaude, entre 70 et 85 °C, puis mise en bocaux et recouverte de graisse, de telle sorte que l\'air ne puisse pas entrer en contact avec elle et la détériorer.', 'contact@lacosina.fr', 'images/Confit_canard.jpg', NOW()),
('Soupe au pistou', 'La soupe au pistou (sopa au psto, soupo au pstou) est une soupe aux légumes d\'été, avec des pâtes, servie avec du pistou, un mélange d\'ail, d\'huile d\'olive et de basilic haché. Le terme pistou désigne, en provençal, le pilon du mortier qui sert à faire la préparation, et non pas le basilic qui se dit baseli.', 'contact@lacosina.fr', 'images/Pistou.jpg', NOW()),
('Tapenade', 'La tapenade (tapenada, tapenado) est une recette de cuisine provençale, mise au point en 1880 par un chef-cuisinier de Marseille. Elle est principalement constituée d\'olives broyées, d\'anchois, de thon marin, d\'herbes et de câpres (tapena en occitan, d\'où son nom).', 'contact@lacosina.fr', 'images/Tapenade.jpg', NOW());

