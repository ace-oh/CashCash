-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 déc. 2023 à 08:33
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

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`idAgences`, `nomAgence`, `rue`, `numRue`, `cpVilleAgence`, `villeAgence`, `paysAgence`, `telAgence`, `mailAgence`) VALUES
(1, 'Agence1', 'Rue A', '123', '75001', 'Paris', 'France', 123456789, 'agence1@mail.com'),
(2, 'Agence2', 'Rue B', '456', '69001', 'Lyon', 'France', 987654321, 'agence2@mail.com'),
(3, 'Agence3', 'Rue C', '789', '13001', 'Marseille', 'France', 456789012, 'agence3@mail.com'),
(4, 'Agence4', 'Rue D', '101', '33001', 'Bordeaux', 'France', 345678901, 'agence4@mail.com'),
(5, 'Agence5', 'Rue E', '112', '67001', 'Strasbourg', 'France', 234567890, 'agence5@mail.com'),
(6, 'Agence6', 'Rue F', '131', '59001', 'Lille', 'France', 123456789, 'agence6@mail.com'),
(7, 'Agence7', 'Rue G', '415', '35001', 'Rennes', 'France', 987654321, 'agence7@mail.com'),
(8, 'Agence8', 'Rue H', '621', '54001', 'Nancy', 'France', 456789012, 'agence8@mail.com'),
(9, 'Agence9', 'Rue I', '813', '31001', 'Toulouse', 'France', 345678901, 'agence9@mail.com'),
(10, 'Agence10', 'Rue J', '922', '67001', 'Nice', 'France', 234567890, 'agence10@mail.com'),
(11, 'Agence11', 'Rue K', '101', '13001', 'Aix-en-Provence', 'France', 123456789, 'agence11@mail.com'),
(12, 'Agence12', 'Rue L', '112', '69001', 'Grenoble', 'France', 987654321, 'agence12@mail.com'),
(13, 'Agence13', 'Rue M', '131', '33001', 'Pessac', 'France', 456789012, 'agence13@mail.com'),
(14, 'Agence14', 'Rue N', '415', '75001', 'Levallois-Perret', 'France', 345678901, 'agence14@mail.com'),
(15, 'Agence15', 'Rue O', '621', '59001', 'Villeneuve-d\'Ascq', 'France', 234567890, 'agence15@mail.com'),
(16, 'Agence16', 'Rue P', '123', '75002', 'Nantes', 'France', 123456789, 'agence16@mail.com'),
(17, 'Agence17', 'Rue Q', '456', '69002', 'Montpellier', 'France', 987654321, 'agence17@mail.com'),
(18, 'Agence18', 'Rue R', '789', '13002', 'Toulon', 'France', 456789012, 'agence18@mail.com'),
(19, 'Agence19', 'Rue S', '101', '33002', 'Angers', 'France', 345678901, 'agence19@mail.com'),
(20, 'Agence20', 'Rue T', '112', '67002', 'Metz', 'France', 234567890, 'agence20@mail.com'),
(21, 'Agence21', 'Rue U', '131', '59002', 'Mulhouse', 'France', 123456789, 'agence21@mail.com'),
(22, 'Agence22', 'Rue V', '415', '35002', 'Saint-Étienne', 'France', 987654321, 'agence22@mail.com'),
(23, 'Agence23', 'Rue W', '621', '54002', 'Avignon', 'France', 456789012, 'agence23@mail.com'),
(24, 'Agence24', 'Rue X', '813', '31002', 'Reims', 'France', 345678901, 'agence24@mail.com'),
(25, 'Agence25', 'Rue Y', '922', '67002', 'Cannes', 'France', 234567890, 'agence25@mail.com'),
(26, 'Agence26', 'Rue Z', '101', '13002', 'Perpignan', 'France', 123456789, 'agence26@mail.com'),
(27, 'Agence27', 'Rue AA', '112', '69002', 'Le Havre', 'France', 987654321, 'agence27@mail.com'),
(28, 'Agence28', 'Rue BB', '131', '33002', 'Limoges', 'France', 456789012, 'agence28@mail.com'),
(29, 'Agence29', 'Rue CC', '415', '35002', 'Brest', 'France', 345678901, 'agence29@mail.com'),
(30, 'Agence30', 'Rue DD', '621', '54002', 'Rouen', 'France', 234567890, 'agence30@mail.com'),
(31, 'Agence31', 'Rue EE', '813', '31002', 'Amiens', 'France', 123456789, 'agence31@mail.com'),
(32, 'Agence32', 'Rue FF', '922', '67002', 'Annecy', 'France', 987654321, 'agence32@mail.com'),
(33, 'Agence33', 'Rue GG', '101', '13002', 'Dijon', 'France', 456789012, 'agence33@mail.com'),
(34, 'Agence34', 'Rue HH', '112', '69002', 'Besançon', 'France', 345678901, 'agence34@mail.com'),
(35, 'Agence35', 'Rue II', '131', '33002', 'Nîmes', 'France', 234567890, 'agence35@mail.com'),
(36, 'Agence36', 'Rue JJ', '415', '35002', 'Valence', 'France', 123456789, 'agence36@mail.com'),
(37, 'Agence37', 'Rue KK', '621', '54002', 'Nancy', 'France', 987654321, 'agence37@mail.com'),
(38, 'Agence38', 'Rue LL', '813', '31002', 'Pau', 'France', 456789012, 'agence38@mail.com'),
(39, 'Agence39', 'Rue MM', '922', '67002', 'Tours', 'France', 345678901, 'agence39@mail.com'),
(40, 'Agence40', 'Rue NN', '101', '13002', 'Clermont-Ferrand', 'France', 234567890, 'agence40@mail.com'),
(41, 'Agence41', 'Rue OO', '112', '69002', 'Caen', 'France', 123456789, 'agence41@mail.com'),
(42, 'Agence42', 'Rue PP', '131', '33002', 'Mulhouse', 'France', 987654321, 'agence42@mail.com'),
(43, 'Agence43', 'Rue QQ', '415', '35002', 'Le Mans', 'France', 456789012, 'agence43@mail.com'),
(44, 'Agence44', 'Rue RR', '621', '54002', 'Cergy', 'France', 345678901, 'agence44@mail.com'),
(45, 'Agence45', 'Rue SS', '813', '31002', 'Ajaccio', 'France', 234567890, 'agence45@mail.com'),
(46, 'Agence46', 'Rue TT', '922', '67002', 'Béziers', 'France', 123456789, 'agence46@mail.com'),
(47, 'Agence47', 'Rue UU', '101', '13002', 'Annemasse', 'France', 987654321, 'agence47@mail.com'),
(48, 'Agence48', 'Rue VV', '112', '69002', 'Roanne', 'France', 456789012, 'agence48@mail.com'),
(49, 'Agence49', 'Rue WW', '131', '33002', 'Saint-Malo', 'France', 345678901, 'agence49@mail.com'),
(50, 'Agence50', 'Rue XX', '415', '35002', 'La Rochelle', 'France', 234567890, 'agence50@mail.com'),
(51, 'Agence51', 'Rue YY', '621', '54002', 'Niort', 'France', 123456789, 'agence51@mail.com'),
(52, 'Agence52', 'Rue ZZ', '813', '31002', 'Quimper', 'France', 987654321, 'agence52@mail.com'),
(54, 'Agence54', 'Rue AAA', '922', '67002', 'Boulogne-Billancourt', 'France', 123456789, 'agence54@mail.com'),
(55, 'Agence55', 'Rue BBB', '101', '13002', 'Courbevoie', 'France', 987654321, 'agence55@mail.com'),
(56, 'Agence56', 'Rue CCC', '112', '59500', 'Douai', 'France', 456789012, 'agence56@mail.com');

-- --------------------------------------------------------

--
-- Structure de la table `assistant`
--

DROP TABLE IF EXISTS `assistant`;
CREATE TABLE IF NOT EXISTS `assistant` (
  `idAssis` varchar(50) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `numTel` varchar(50) DEFAULT NULL,
  `mdp` varchar(100) DEFAULT NULL,
  `idAgences` int NOT NULL,
  PRIMARY KEY (`idAssis`),
  KEY `idAgences` (`idAgences`)
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

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `SIREN`, `codeAb`, `rue`, `numRue`, `cpVille`, `ville`, `pays`, `numTel`, `mail`, `idAgences`) VALUES
(0, 'SIREN16', 'CodeAB16', 16, '1776', 16001, 'Ville16', 'France', '12345678916', 'client16@mail.com', 16),
(1, 'SIREN1', 'CodeAB1', 1, '123', 75001, 'Paris', 'France', '1234567890', 'client1@mail.com', 1),
(2, 'SIREN2', 'CodeAB2', 2, '456', 69001, 'Lyon', 'France', '9876543210', 'client2@mail.com', 2),
(3, 'SIREN3', 'CodeAB3', 3, '789', 13001, 'Marseille', 'France', '4567890123', 'client3@mail.com', 3),
(4, 'SIREN4', 'CodeAB4', 4, '101', 33001, 'Bordeaux', 'France', '3456789012', 'client4@mail.com', 4),
(5, 'SIREN5', 'CodeAB5', 5, '112', 67001, 'Strasbourg', 'France', '2345678901', 'client5@mail.com', 5),
(6, 'SIREN6', 'CodeAB6', 6, '131', 59001, 'Lille', 'France', '1234567890', 'client6@mail.com', 6),
(7, 'SIREN7', 'CodeAB7', 7, '415', 35001, 'Rennes', 'France', '9876543210', 'client7@mail.com', 7),
(8, 'SIREN8', 'CodeAB8', 8, '621', 54001, 'Nancy', 'France', '4567890123', 'client8@mail.com', 8),
(9, 'SIREN9', 'CodeAB9', 9, '813', 31001, 'Toulouse', 'France', '3456789012', 'client9@mail.com', 9),
(10, 'SIREN10', 'CodeAB10', 10, '922', 67001, 'Nice', 'France', '2345678901', 'client10@mail.com', 10),
(11, 'SIREN11', 'CodeAB11', 11, '101', 13001, 'Aix-en-Provence', 'France', '1234567890', 'client11@mail.com', 11),
(12, 'SIREN12', 'CodeAB12', 12, '112', 69001, 'Grenoble', 'France', '9876543210', 'client12@mail.com', 12),
(13, 'SIREN13', 'CodeAB13', 13, '131', 33001, 'Pessac', 'France', '4567890123', 'client13@mail.com', 13),
(14, 'SIREN14', 'CodeAB14', 14, '415', 75001, 'Levallois-Perret', 'France', '3456789012', 'client14@mail.com', 14),
(15, 'SIREN15', 'CodeAB15', 15, '621', 59001, 'Villeneuve-d\'Ascq', 'France', '2345678901', 'client15@mail.com', 15);

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

--
-- Déchargement des données de la table `contratmaintenance`
--

INSERT INTO `contratmaintenance` (`idContrat`, `dateSignature`, `dateEcheance`, `dateRenou`, `modifDateEcheance`, `idClient`) VALUES
(1, '2023-01-01', '2024-01-01', '2023-12-01', '2023-11-01', 1),
(2, '2023-02-01', '2024-02-01', '2023-12-01', '2023-11-01', 2),
(3, '2023-03-01', '2024-03-01', '2023-12-01', '2023-11-01', 3),
(4, '2023-04-01', '2024-04-01', '2023-12-01', '2023-11-01', 4),
(5, '2023-05-01', '2024-05-01', '2023-12-01', '2023-11-01', 5),
(6, '2023-06-01', '2024-06-01', '2023-12-01', '2023-11-01', 6),
(7, '2023-07-01', '2024-07-01', '2023-12-01', '2023-11-01', 7),
(8, '2023-08-01', '2024-08-01', '2023-12-01', '2023-11-01', 8),
(9, '2023-09-01', '2024-09-01', '2023-12-01', '2023-11-01', 9),
(10, '2023-10-01', '2024-10-01', '2023-12-01', '2023-11-01', 10),
(11, '2023-11-01', '2024-11-01', '2023-12-01', '2023-11-01', 11),
(12, '2023-12-01', '2024-12-01', '2023-12-01', '2023-11-01', 12),
(13, '2024-01-01', '2025-01-01', '2023-12-01', '2023-11-01', 13),
(14, '2024-02-01', '2025-02-01', '2023-12-01', '2023-11-01', 14),
(15, '2024-03-01', '2025-03-01', '2023-12-01', '2023-11-01', 15);

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

--
-- Déchargement des données de la table `demander`
--

INSERT INTO `demander` (`idClient`, `idInter`) VALUES
(1, 'Inter1'),
(10, 'Inter10'),
(11, 'Inter11'),
(12, 'Inter12'),
(13, 'Inter13'),
(14, 'Inter14'),
(15, 'Inter15'),
(2, 'Inter2'),
(3, 'Inter3'),
(4, 'Inter4'),
(5, 'Inter5'),
(6, 'Inter6'),
(7, 'Inter7'),
(8, 'Inter8'),
(9, 'Inter9');

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

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`idInter`, `clientInter`, `dateInter`, `dateFinInter`, `contratInter`) VALUES
('Inter1', 'Client1', '2023-01-01', '2023-01-02', 'Contrat1'),
('Inter10', 'Client10', '2023-10-01', '2023-10-02', 'Contrat10'),
('Inter11', 'Client11', '2023-11-01', '2023-11-02', 'Contrat11'),
('Inter12', 'Client12', '2023-12-01', '2023-12-02', 'Contrat12'),
('Inter13', 'Client13', '2024-01-01', '2024-01-02', 'Contrat13'),
('Inter14', 'Client14', '2024-02-01', '2024-02-02', 'Contrat14'),
('Inter15', 'Client15', '2024-03-01', '2024-03-02', 'Contrat15'),
('Inter2', 'Client2', '2023-02-01', '2023-02-02', 'Contrat2'),
('Inter3', 'Client3', '2023-03-01', '2023-03-02', 'Contrat3'),
('Inter4', 'Client4', '2023-04-01', '2023-04-02', 'Contrat4'),
('Inter5', 'Client5', '2023-05-01', '2023-05-02', 'Contrat5'),
('Inter6', 'Client6', '2023-06-01', '2023-06-02', 'Contrat6'),
('Inter7', 'Client7', '2023-07-01', '2023-07-02', 'Contrat7'),
('Inter8', 'Client8', '2023-08-01', '2023-08-02', 'Contrat8'),
('Inter9', 'Client9', '2023-09-01', '2023-09-02', 'Contrat9');

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

--
-- Déchargement des données de la table `matériel`
--

INSERT INTO `matériel` (`idMateriel`, `numSerie`, `dateVente`, `dateInstallation`, `prixVente`, `emplacementClient`, `finGarantie`, `idClient`, `idContrat`) VALUES
('Materiel1', '123ABC', '2023-01-01', '2023-01-02', '1000', 'Emplacement1', '2024-01-01', 1, 1),
('Materiel10', '922BCD', '2023-10-01', '2023-10-02', '5500', 'Emplacement10', '2024-10-01', 10, 10),
('Materiel11', '101EFG', '2023-11-01', '2023-11-02', '6000', 'Emplacement11', '2024-11-01', 11, 11),
('Materiel12', '112HIJ', '2023-12-01', '2023-12-02', '6500', 'Emplacement12', '2024-12-01', 12, 12),
('Materiel13', '131KLM', '2024-01-01', '2024-01-02', '7000', 'Emplacement13', '2025-01-01', 13, 13),
('Materiel14', '415NOP', '2024-02-01', '2024-02-02', '7500', 'Emplacement14', '2025-02-01', 14, 14),
('Materiel15', '621QRS', '2024-03-01', '2024-03-02', '8000', 'Emplacement15', '2025-03-01', 15, 15),
('Materiel2', '456DEF', '2023-02-01', '2023-02-02', '1500', 'Emplacement2', '2024-02-01', 2, 2),
('Materiel3', '789GHI', '2023-03-01', '2023-03-02', '2000', 'Emplacement3', '2024-03-01', 3, 3),
('Materiel4', '101JKL', '2023-04-01', '2023-04-02', '2500', 'Emplacement4', '2024-04-01', 4, 4),
('Materiel5', '112MNO', '2023-05-01', '2023-05-02', '3000', 'Emplacement5', '2024-05-01', 5, 5),
('Materiel6', '131PQR', '2023-06-01', '2023-06-02', '3500', 'Emplacement6', '2024-06-01', 6, 6),
('Materiel7', '415STU', '2023-07-01', '2023-07-02', '4000', 'Emplacement7', '2024-07-01', 7, 7),
('Materiel8', '621VWX', '2023-08-01', '2023-08-02', '4500', 'Emplacement8', '2024-08-01', 8, 8),
('Materiel9', '813YZA', '2023-09-01', '2023-09-02', '5000', 'Emplacement9', '2024-09-01', 9, 9);

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

--
-- Déchargement des données de la table `renouveller`
--

INSERT INTO `renouveller` (`dateRenou`, `modifDateEcheance`) VALUES
('2023-12-01', '2023-11-01'),
('2024-01-01', '2023-12-01'),
('2024-02-01', '2023-12-01'),
('2024-03-01', '2023-12-01'),
('2024-04-01', '2023-12-01'),
('2024-05-01', '2023-12-01'),
('2024-06-01', '2023-12-01'),
('2024-07-01', '2023-12-01'),
('2024-08-01', '2023-12-01'),
('2024-09-01', '2023-12-01'),
('2024-10-01', '2023-12-01'),
('2024-11-01', '2023-12-01'),
('2024-12-01', '2023-12-01'),
('2025-01-01', '2023-12-01'),
('2025-02-01', '2023-12-01');

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
  `mdp` varchar(100) NOT NULL,
  PRIMARY KEY (`idTech`),
  KEY `idAgences` (`idAgences`),
  KEY `idInter` (`idInter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `technicien`
--

INSERT INTO `technicien` (`idTech`, `nom`, `prenom`, `mail`, `numTel`, `dateDebutContrat`, `dateFinContrat`, `idAgences`, `idInter`, `mdp`) VALUES
('Tech1', 'Nom1', 'Prenom1', 'tech1@mail.com', 1234567890, '2023-01-01', '2024-01-01', 1, 'Inter1', ''),
('Tech10', 'Nom10', 'Prenom10', 'tech10@mail.com', 2147483647, '2023-10-01', '2024-10-01', 10, 'Inter10', ''),
('Tech11', 'Nom11', 'Prenom11', 'tech11@mail.com', 1234567890, '2023-11-01', '2024-11-01', 11, 'Inter11', ''),
('Tech12', 'Nom12', 'Prenom12', 'tech12@mail.com', 2147483647, '2023-12-01', '2024-12-01', 12, 'Inter12', ''),
('Tech13', 'Nom13', 'Prenom13', 'tech13@mail.com', 2147483647, '2024-01-01', '2025-01-01', 13, 'Inter13', ''),
('Tech14', 'Nom14', 'Prenom14', 'tech14@mail.com', 2147483647, '2024-02-01', '2025-02-01', 14, 'Inter14', ''),
('Tech15', 'Nom15', 'Prenom15', 'tech15@mail.com', 2147483647, '2024-03-01', '2025-03-01', 15, 'Inter15', ''),
('Tech2', 'Nom2', 'Prenom2', 'tech2@mail.com', 2147483647, '2023-02-01', '2024-02-01', 2, 'Inter2', ''),
('Tech3', 'Nom3', 'Prenom3', 'tech3@mail.com', 2147483647, '2023-03-01', '2024-03-01', 3, 'Inter3', ''),
('Tech4', 'Nom4', 'Prenom4', 'tech4@mail.com', 2147483647, '2023-04-01', '2024-04-01', 4, 'Inter4', ''),
('Tech5', 'Nom5', 'Prenom5', 'tech5@mail.com', 2147483647, '2023-05-01', '2024-05-01', 5, 'Inter5', ''),
('Tech6', 'Nom6', 'Prenom6', 'tech6@mail.com', 1234567890, '2023-06-01', '2024-06-01', 6, 'Inter6', ''),
('Tech7', 'Nom7', 'Prenom7', 'tech7@mail.com', 2147483647, '2023-07-01', '2024-07-01', 7, 'Inter7', ''),
('Tech8', 'Nom8', 'Prenom8', 'tech8@mail.com', 2147483647, '2023-08-01', '2024-08-01', 8, 'Inter8', ''),
('Tech9', 'Nom9', 'Prenom9', 'tech9@mail.com', 2147483647, '2023-09-01', '2024-09-01', 9, 'Inter9', '');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assistant`
--
ALTER TABLE `assistant`
  ADD CONSTRAINT `assistant_ibfk_1` FOREIGN KEY (`idAgences`) REFERENCES `agences` (`idAgences`);

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
