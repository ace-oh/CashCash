-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 15 nov. 2023 à 09:18
-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ap2`
--

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

DROP TABLE IF EXISTS `agences`;
CREATE TABLE IF NOT EXISTS `agences` (
  `idAgences` int NOT NULL,
  `nomAgence` varchar(50) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `numRue` varchar(50) DEFAULT NULL,
  `cpVilleAgence` varchar(50) DEFAULT NULL,
  `villeAgence` varchar(50) DEFAULT NULL,
  `paysAgence` varchar(50) DEFAULT NULL,
  `telAgence` int DEFAULT NULL,
  `mailAgence` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAgences`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int NOT NULL,
  `SIREN` varchar(50) NOT NULL,
  `codeAb` varchar(50) NOT NULL,
  `rue` int NOT NULL,
  `numRue` varchar(50) DEFAULT NULL,
  `cpVille` int NOT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `numTel` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `idAgences` int NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `idAgences` (`idAgences`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contratmaintenance`
--

DROP TABLE IF EXISTS `contratmaintenance`;
CREATE TABLE IF NOT EXISTS `contratmaintenance` (
  `idContrat` int NOT NULL,
  `dateSignature` date DEFAULT NULL,
  `dateEcheance` date DEFAULT NULL,
  `dateRenou` date DEFAULT NULL,
  `modifDateEcheance` date DEFAULT NULL,
  `idClient` int NOT NULL,
  PRIMARY KEY (`idContrat`),
  UNIQUE KEY `idClient` (`idClient`),
  KEY `dateRenou` (`dateRenou`,`modifDateEcheance`),
  KEY `modifDateEcheance` (`modifDateEcheance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demander`
--

DROP TABLE IF EXISTS `demander`;
CREATE TABLE IF NOT EXISTS `demander` (
  `idClient` int NOT NULL,
  `idInter` varchar(50) NOT NULL,
  PRIMARY KEY (`idClient`,`idInter`),
  KEY `idInter` (`idInter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `idInter` varchar(50) NOT NULL,
  `clientInter` varchar(50) DEFAULT NULL,
  `dateInter` date DEFAULT NULL,
  `dateFinInter` date DEFAULT NULL,
  `contratInter` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idInter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matériel`
--

DROP TABLE IF EXISTS `matériel`;
CREATE TABLE IF NOT EXISTS `matériel` (
  `idMateriel` varchar(50) NOT NULL,
  `numSerie` varchar(50) NOT NULL,
  `dateVente` date DEFAULT NULL,
  `dateInstallation` date DEFAULT NULL,
  `prixVente` varchar(50) DEFAULT NULL,
  `emplacementClient` varchar(50) DEFAULT NULL,
  `finGarantie` varchar(50) DEFAULT NULL,
  `idClient` int NOT NULL,
  `idContrat` int NOT NULL,
  PRIMARY KEY (`idMateriel`),
  KEY `idClient` (`idClient`),
  KEY `idContrat` (`idContrat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `renouveller`
--

DROP TABLE IF EXISTS `renouveller`;
CREATE TABLE IF NOT EXISTS `renouveller` (
  `dateRenou` date NOT NULL,
  `modifDateEcheance` date NOT NULL,
  PRIMARY KEY (`dateRenou`,`modifDateEcheance`),
  KEY `modifDateEcheance` (`modifDateEcheance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

DROP TABLE IF EXISTS `technicien`;
CREATE TABLE IF NOT EXISTS `technicien` (
  `idTech` varchar(50) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `numTel` int DEFAULT NULL,
  `dateDebutContrat` date NOT NULL,
  `dateFinContrat` date DEFAULT NULL,
  `idAgences` int NOT NULL,
  `idInter` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idTech`),
  KEY `idAgences` (`idAgences`),
  KEY `idInter` (`idInter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`idAgences`) REFERENCES `agences` (`idAgences`);

--
-- Contraintes pour la table `contratmaintenance`
--
ALTER TABLE `contratmaintenance`
  ADD CONSTRAINT `contratmaintenance_ibfk_1` FOREIGN KEY (`dateRenou`) REFERENCES `renouveller` (`dateRenou`),
  ADD CONSTRAINT `contratmaintenance_ibfk_2` FOREIGN KEY (`modifDateEcheance`) REFERENCES `renouveller` (`modifDateEcheance`),
  ADD CONSTRAINT `contratmaintenance_ibfk_3` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `demander`
--
ALTER TABLE `demander`
  ADD CONSTRAINT `demander_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `demander_ibfk_2` FOREIGN KEY (`idInter`) REFERENCES `intervention` (`idInter`);

--
-- Contraintes pour la table `matériel`
--
ALTER TABLE `matériel`
  ADD CONSTRAINT `matériel_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `matériel_ibfk_2` FOREIGN KEY (`idContrat`) REFERENCES `contratmaintenance` (`idContrat`);

--
-- Contraintes pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD CONSTRAINT `technicien_ibfk_1` FOREIGN KEY (`idAgences`) REFERENCES `agences` (`idAgences`),
  ADD CONSTRAINT `technicien_ibfk_2` FOREIGN KEY (`idInter`) REFERENCES `intervention` (`idInter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
