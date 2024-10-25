-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 oct. 2024 à 06:52
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_dg`
--

-- --------------------------------------------------------

--
-- Structure de la table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand` char(255) NOT NULL,
  `model` char(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `category` char(255) NOT NULL,
  `images` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `description`, `price`, `category`, `images`) VALUES
(1, 'Toyota', 'Celica', 'Toyota Celica GT 1995, 256000km.', 10000, '0', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `firstname` char(255) NOT NULL,
  `lastname` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `firstname`, `lastname`, `password`, `roles`) VALUES
(1, 'ALFClarel', 'Clarel', 'GRONDIN', 'test', '[\"ROLE_ADMIN\"]');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
