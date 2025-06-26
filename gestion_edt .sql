-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 14 juin 2025 à 16:32
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_edt`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation_ecue`
--

DROP TABLE IF EXISTS `affectation_ecue`;
CREATE TABLE IF NOT EXISTS `affectation_ecue` (
  `idAffectationECUE` int NOT NULL AUTO_INCREMENT,
  `codeECUE` varchar(200) NOT NULL,
  `matricule` varchar(200) NOT NULL,
  `noClasse` int NOT NULL,
  PRIMARY KEY (`idAffectationECUE`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `affectation_ecue`
--

INSERT INTO `affectation_ecue` (`idAffectationECUE`, `codeECUE`, `matricule`, `noClasse`) VALUES
(1, 'INF103', '2205', 1),
(2, 'INF102', '2405', 2),
(3, 'INF103', '2205', 4),
(4, 'INF102', '2405', 1),
(5, 'MATH202', '2308', 1),
(6, 'MATH203', '2308', 1),
(7, 'INF102', '2405', 3),
(8, 'MATH202', '2308', 3),
(9, 'INF103', '2405', 3);

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `noClasse` int NOT NULL AUTO_INCREMENT,
  `nomClasse` text NOT NULL,
  PRIMARY KEY (`noClasse`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`noClasse`, `nomClasse`) VALUES
(1, 'L1 Informatique'),
(2, 'L2 Informatique'),
(3, 'L3 Informatique'),
(4, 'L1 Mathématiques'),
(5, 'L2 Mathématiques'),
(6, 'L3 Mathématiques');

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
CREATE TABLE IF NOT EXISTS `domaine` (
  `noDomaine` int NOT NULL AUTO_INCREMENT,
  `nomDomaine` text NOT NULL,
  PRIMARY KEY (`noDomaine`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `domaine`
--

INSERT INTO `domaine` (`noDomaine`, `nomDomaine`) VALUES
(1, 'Informatique'),
(2, 'Mathématiques'),
(3, 'Biologie');

-- --------------------------------------------------------

--
-- Structure de la table `ecue`
--

DROP TABLE IF EXISTS `ecue`;
CREATE TABLE IF NOT EXISTS `ecue` (
  `codeECUE` varchar(200) NOT NULL,
  `libECUE` text NOT NULL,
  `coefECUE` int NOT NULL,
  `nbHeure` int NOT NULL,
  `codeUE` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `noSpe` int NOT NULL,
  PRIMARY KEY (`codeECUE`),
  KEY `codeUE` (`codeUE`),
  KEY `noSpe` (`noSpe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ecue`
--

INSERT INTO `ecue` (`codeECUE`, `libECUE`, `coefECUE`, `nbHeure`, `codeUE`, `noSpe`) VALUES
('INF102', 'Framework mobile', 2, 30, 'INF101', 2),
('INF103', 'Traitement de données', 2, 30, 'INF101', 1),
('MATH201', 'Quantificateurs logiques', 2, 40, 'MATH101', 8),
('MATH202', 'Raisonnement', 2, 45, 'MATH101', 9),
('MATH203', 'Ensembles', 2, 50, 'MATH101', 7),
('WEB101', 'Front-end WEB', 2, 50, 'INF101', 3);

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `matricule` varchar(200) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  PRIMARY KEY (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`matricule`, `nom`, `prenom`, `email`, `tel`) VALUES
('2205', 'Guiraud', 'Jean-marc', 'guiraud@inphb.ci', '05458565'),
('2308', 'Coulibaly', 'Lassina', 'coulibaly@inphb.ci', '07584595'),
('2405', 'Kalou', 'Joseph', 'kalou@inphb.ci', '05056535'),
('2606', 'Kouakou', 'Marguerite', 'kouakou@inphb.ci', '07546556');

-- --------------------------------------------------------

--
-- Structure de la table `prof_spe`
--

DROP TABLE IF EXISTS `prof_spe`;
CREATE TABLE IF NOT EXISTS `prof_spe` (
  `idProfSpe` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(200) NOT NULL,
  `noSpe` int NOT NULL,
  PRIMARY KEY (`idProfSpe`),
  KEY `matricule` (`matricule`),
  KEY `noSpe` (`noSpe`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `prof_spe`
--

INSERT INTO `prof_spe` (`idProfSpe`, `matricule`, `noSpe`) VALUES
(1, '2308', 7),
(2, '2308', 9),
(3, '2405', 1),
(4, '2205', 1),
(5, '2405', 2),
(6, '2606', 3);

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
CREATE TABLE IF NOT EXISTS `specialite` (
  `noSpe` int NOT NULL AUTO_INCREMENT,
  `nomSpe` text NOT NULL,
  `noDomaine` int NOT NULL,
  PRIMARY KEY (`noSpe`),
  KEY `noDomaine` (`noDomaine`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`noSpe`, `nomSpe`, `noDomaine`) VALUES
(1, 'Python ', 1),
(2, 'React Native', 1),
(3, 'Flutter Web', 1),
(7, 'Espaces vectoriels', 2),
(8, 'Langages formels', 2),
(9, 'Complexité algorithmique', 2);

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

DROP TABLE IF EXISTS `ue`;
CREATE TABLE IF NOT EXISTS `ue` (
  `codeUE` varchar(200) NOT NULL,
  `libUE` text NOT NULL,
  `coefUE` int NOT NULL,
  `noSemestre` int NOT NULL,
  PRIMARY KEY (`codeUE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ue`
--

INSERT INTO `ue` (`codeUE`, `libUE`, `coefUE`, `noSemestre`) VALUES
('INF101', 'Programmation WEB', 4, 1),
('INFO102', 'Programmation objet', 4, 2),
('MATH101', 'Mathématiques discrètes', 4, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ecue`
--
ALTER TABLE `ecue`
  ADD CONSTRAINT `ecue_ibfk_1` FOREIGN KEY (`codeUE`) REFERENCES `ue` (`codeUE`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ecue_ibfk_2` FOREIGN KEY (`noSpe`) REFERENCES `specialite` (`noSpe`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `prof_spe`
--
ALTER TABLE `prof_spe`
  ADD CONSTRAINT `prof_spe_ibfk_1` FOREIGN KEY (`matricule`) REFERENCES `professeur` (`matricule`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prof_spe_ibfk_2` FOREIGN KEY (`noSpe`) REFERENCES `specialite` (`noSpe`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD CONSTRAINT `specialite_ibfk_1` FOREIGN KEY (`noDomaine`) REFERENCES `domaine` (`noDomaine`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
