-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 04 avr. 2025 à 07:21
-- Version du serveur : 5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sigmax`
--
CREATE DATABASE IF NOT EXISTS `sigmax` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sigmax`;

-- --------------------------------------------------------

--
-- Structure de la table `adminsysteme`
--

CREATE TABLE IF NOT EXISTS `adminsysteme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jour` date NOT NULL,
  `heure` time NOT NULL,
  `ip` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cle`
--

CREATE TABLE IF NOT EXISTS `cle` (
  `cle_rc4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cle`
--

INSERT INTO `cle` (`cle_rc4`) VALUES
('saesigmax');

-- --------------------------------------------------------

--
-- Structure de la table `crypto`
--

CREATE TABLE IF NOT EXISTS `crypto` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `cle` varchar(255) NOT NULL,
  `texte` varchar(255) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crypto_ibfk_1` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `methode` varchar(255) NOT NULL,
  `n` int(11) NOT NULL,
  `forme` double NOT NULL,
  `esperance` double NOT NULL,
  `t` double NOT NULL,
  `resultat` double NOT NULL,
  `id_user` int(4) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `polynomial`
--

CREATE TABLE IF NOT EXISTS `polynomial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `a` int(255) NOT NULL,
  `b` int(255) NOT NULL,
  `c` int(4) NOT NULL,
  `delta` int(4) NOT NULL,
  `unique` varchar(255) NOT NULL,
  `reel1` varchar(255) NOT NULL,
  `reel2` varchar(255) NOT NULL,
  `comp1` varchar(255) NOT NULL,
  `comp2` varchar(255) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `polynomial_ibfk_1` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'adminweb', 'fbb9ef173c00a574'),
(2, 'adminsys', 'fbb9ef173c04b965');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `crypto`
--
ALTER TABLE `crypto`
  ADD CONSTRAINT `crypto_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `polynomial`
--
ALTER TABLE `polynomial`
  ADD CONSTRAINT `polynomial_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
