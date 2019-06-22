-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 22 juin 2019 à 10:19
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `webreathe`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_user`) VALUES
(1);

-- --------------------------------------------------------

--
-- Structure de la table `affectermaintenance`
--

DROP TABLE IF EXISTS `affectermaintenance`;
CREATE TABLE IF NOT EXISTS `affectermaintenance` (
  `id_user` int(11) NOT NULL,
  `id_maintenance` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_maintenance`),
  KEY `id_user` (`id_user`,`id_maintenance`),
  KEY `ct_maintenance_maintenance` (`id_maintenance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `affectermaintenance`
--

INSERT INTO `affectermaintenance` (`id_user`, `id_maintenance`) VALUES
(2, 27),
(2, 28);

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaires`
--

DROP TABLE IF EXISTS `gestionnaires`;
CREATE TABLE IF NOT EXISTS `gestionnaires` (
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gestionnaires`
--

INSERT INTO `gestionnaires` (`id_user`) VALUES
(3);

-- --------------------------------------------------------

--
-- Structure de la table `listepieces`
--

DROP TABLE IF EXISTS `listepieces`;
CREATE TABLE IF NOT EXISTS `listepieces` (
  `id_pieces` int(11) NOT NULL,
  `id_maintenance` int(11) NOT NULL,
  PRIMARY KEY (`id_pieces`,`id_maintenance`),
  KEY `id_pieces` (`id_pieces`,`id_maintenance`),
  KEY `ct_maintenance` (`id_maintenance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `listepieces`
--

INSERT INTO `listepieces` (`id_pieces`, `id_maintenance`) VALUES
(1, 27),
(2, 27),
(1, 28),
(2, 28);

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `etatAvancement` varchar(255) NOT NULL,
  `id_probleme` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_probleme` (`id_probleme`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`id`, `dateDebut`, `dateFin`, `sujet`, `description`, `etatAvancement`, `id_probleme`) VALUES
(27, '2019-04-10', '2019-06-10', 'Probleme vieux', 'La distribuion doit etre faite', 'en cours', 9),
(28, '2019-07-14', '2019-08-14', 'Voyant moteur', 'Changement du moteur et de son Ã©chappement', 'en attente', 10),
(29, '2019-04-02', '2019-04-17', 'h', 'hhh', 'termine', 11),
(30, '2019-05-02', '2019-05-22', 'lll', 'llll', 'termine', 11);

-- --------------------------------------------------------

--
-- Structure de la table `notemaintenance`
--

DROP TABLE IF EXISTS `notemaintenance`;
CREATE TABLE IF NOT EXISTS `notemaintenance` (
  `note` int(11) NOT NULL,
  `id_maintenance` int(11) NOT NULL,
  `id_technicien` int(11) NOT NULL,
  PRIMARY KEY (`id_maintenance`,`id_technicien`),
  KEY `id_maintenance` (`id_maintenance`),
  KEY `id_technicien` (`id_technicien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notemaintenance`
--

INSERT INTO `notemaintenance` (`note`, `id_maintenance`, `id_technicien`) VALUES
(1, 27, 2);

-- --------------------------------------------------------

--
-- Structure de la table `photomaintenance`
--

DROP TABLE IF EXISTS `photomaintenance`;
CREATE TABLE IF NOT EXISTS `photomaintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `id_maintenance` int(11) NOT NULL,
  `id_technicien` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_maintenance` (`id_maintenance`),
  KEY `id_technicien` (`id_technicien`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photomaintenance`
--

INSERT INTO `photomaintenance` (`id`, `path`, `id_maintenance`, `id_technicien`) VALUES
(2, 'https://elemca.com/wp2015/wp-content/uploads/2016/08/Pi%C3%A8ce-m%C3%A9ca.png', 27, 2);

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

DROP TABLE IF EXISTS `pieces`;
CREATE TABLE IF NOT EXISTS `pieces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `libelle`) VALUES
(1, 'Moteur'),
(2, 'Echappement'),
(3, 'Train roulant '),
(4, 'Eclairage'),
(5, 'Chauffage/ventilation');

-- --------------------------------------------------------

--
-- Structure de la table `problemevehicule`
--

DROP TABLE IF EXISTS `problemevehicule`;
CREATE TABLE IF NOT EXISTS `problemevehicule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raison` varchar(255) NOT NULL,
  `immatriculation` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `immatriculation` (`immatriculation`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `problemevehicule`
--

INSERT INTO `problemevehicule` (`id`, `raison`, `immatriculation`) VALUES
(9, 'dd', 'AC-252-FE'),
(10, 'Voyant moteur', 'BC-450-ZE'),
(11, 'Ne dÃ©marre plus', 'EF-510-AZ');

-- --------------------------------------------------------

--
-- Structure de la table `techniciens`
--

DROP TABLE IF EXISTS `techniciens`;
CREATE TABLE IF NOT EXISTS `techniciens` (
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_technicien` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `techniciens`
--

INSERT INTO `techniciens` (`id_user`) VALUES
(2),
(4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`) VALUES
(1, 'admin@admin.fr', 'Vervisch', 'admin'),
(2, 'tech@tech.fr', 'Dupont', 'tech'),
(3, 'gest@gest.fr', 'Charles', 'gest'),
(4, 'tech2@tech.fr', 'Jean', 'tech');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

DROP TABLE IF EXISTS `vehicules`;
CREATE TABLE IF NOT EXISTS `vehicules` (
  `immatriculation` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `dateAchat` date NOT NULL,
  PRIMARY KEY (`immatriculation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`immatriculation`, `type`, `dateAchat`) VALUES
('AC-252-FE', 'Monospace', '1999-10-25'),
('BC-450-ZE', 'Berline', '2010-10-20'),
('EF-510-AZ', 'Sport', '2019-06-20');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `ct_user_admin` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `affectermaintenance`
--
ALTER TABLE `affectermaintenance`
  ADD CONSTRAINT `ct_maintenance_maintenance` FOREIGN KEY (`id_maintenance`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_maintenance_tech` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gestionnaires`
--
ALTER TABLE `gestionnaires`
  ADD CONSTRAINT `ct_user_gestionnaires` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `listepieces`
--
ALTER TABLE `listepieces`
  ADD CONSTRAINT `ct_maintenance` FOREIGN KEY (`id_maintenance`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_piece` FOREIGN KEY (`id_pieces`) REFERENCES `pieces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `ct_probleme_maintenance` FOREIGN KEY (`id_probleme`) REFERENCES `problemevehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notemaintenance`
--
ALTER TABLE `notemaintenance`
  ADD CONSTRAINT `ct_note_maintenance` FOREIGN KEY (`id_maintenance`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_note_technicien` FOREIGN KEY (`id_technicien`) REFERENCES `techniciens` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `photomaintenance`
--
ALTER TABLE `photomaintenance`
  ADD CONSTRAINT `ct_image_user` FOREIGN KEY (`id_technicien`) REFERENCES `techniciens` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_photo_maintenance` FOREIGN KEY (`id_maintenance`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `problemevehicule`
--
ALTER TABLE `problemevehicule`
  ADD CONSTRAINT `ct_probleme_vehicule` FOREIGN KEY (`immatriculation`) REFERENCES `vehicules` (`immatriculation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `techniciens`
--
ALTER TABLE `techniciens`
  ADD CONSTRAINT `ct_user_technicien` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
