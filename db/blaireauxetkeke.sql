-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 19 avr. 2019 à 16:59
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `flaque`;
DROP TABLE IF EXISTS `mur`;
DROP TABLE IF EXISTS `user-partie`;
DROP TABLE IF EXISTS `partie`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `map`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blaireauxetkeke`
--

-- --------------------------------------------------------

--
-- Structure de la table `flaque`
--

CREATE TABLE IF NOT EXISTS `flaque` (
  `idMap` int(11) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  KEY `idMap` (`idMap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `map`
--

CREATE TABLE IF NOT EXISTS `map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mur`
--

CREATE TABLE IF NOT EXISTS `mur` (
  `idMap` int(11) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  KEY `idMap` (`idMap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE IF NOT EXISTS `partie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etat` tinyint(1) NOT NULL COMMENT 'Terminé = -1 /En Attente = 0/En Cours = 1',
  `date` datetime NOT NULL,
  `idMap` int(11) NOT NULL,
  `nbParticipant` int(11) NOT NULL,
  `dimension` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idMap` (`idMap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Partie';

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `mdp` varchar(1000) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `score` int(11) NOT NULL,
  `classement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `mdp`, `admin`, `score`, `classement`) VALUES
(1, 'admin', 'admin', 1, 0, 0),
(2, 'kcrach', 'c20ad4d76fe97759aa27a0c99bff6710', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user-partie`
--

CREATE TABLE IF NOT EXISTS `user-partie` (
  `idUser` int(11) NOT NULL,
  `idPartie` int(11) NOT NULL,
  `typeUser` varchar(20) NOT NULL COMMENT 'Joueur/Host/Spec',
  `posX` int(11) DEFAULT NULL,
  `posY` int(11) DEFAULT NULL,
  `equipe` varchar(20) DEFAULT NULL,
  KEY `idUser` (`idUser`),
  KEY `idPartie` (`idPartie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `flaque`
--
ALTER TABLE `flaque`
  ADD CONSTRAINT `flaque_ibfk_1` FOREIGN KEY (`idMap`) REFERENCES `map` (`id`);

--
-- Contraintes pour la table `mur`
--
ALTER TABLE `mur`
  ADD CONSTRAINT `mur_ibfk_1` FOREIGN KEY (`idMap`) REFERENCES `map` (`id`);

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`idMap`) REFERENCES `map` (`id`);

--
-- Contraintes pour la table `user-partie`
--
ALTER TABLE `user-partie`
  ADD CONSTRAINT `user-partie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user-partie_ibfk_2` FOREIGN KEY (`idPartie`) REFERENCES `partie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
