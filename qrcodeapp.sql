-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 14 oct. 2023 à 13:53
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `qrcodeapp`
--
CREATE DATABASE IF NOT EXISTS `qrcodeapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `qrcodeapp`;

-- --------------------------------------------------------

--
-- Structure de la table `lien`
--

CREATE TABLE `lien` (
  `idQR` int(11) NOT NULL,
  `lien` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `localisation`
--

CREATE TABLE `localisation` (
  `idQR` int(11) NOT NULL,
  `latitude` varchar(25) NOT NULL,
  `longitude` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mail`
--

CREATE TABLE `mail` (
  `idQR` int(11) NOT NULL,
  `mail` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `qr`
--

CREATE TABLE `qr` (
  `idQR` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `margin` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `label` varchar(25) NOT NULL,
  `labelposition` varchar(25) NOT NULL DEFAULT 'center',
  `error` varchar(25) NOT NULL DEFAULT 'medium',
  `backgroundcolor` varchar(35) NOT NULL DEFAULT '255.255.255.127',
  `foregroundcolor` varchar(35) NOT NULL DEFAULT '0.0.0',
  `labelcolor` varchar(35) NOT NULL DEFAULT '0.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sms`
--

CREATE TABLE `sms` (
  `idQR` int(11) NOT NULL,
  `sms` varchar(15) NOT NULL,
  `numero` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `telephone`
--

CREATE TABLE `telephone` (
  `idQR` int(11) NOT NULL,
  `telephone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Structure de la table `text`
--

CREATE TABLE `text` (
  `idQR` int(11) NOT NULL,
  `text` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `pseudo` varchar(75) NOT NULL,
  `password` varchar(256) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `RememberIdentifier` text DEFAULT NULL,
  `RememberToken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vcard`
--

CREATE TABLE `vcard` (
  `idQR` int(11) NOT NULL,
  `nom` varchar(75) NOT NULL,
  `prenom` varchar(75) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `site` varchar(2048) DEFAULT NULL,
  `telephone` varchar(15) NOT NULL,
  `entreprise` varchar(200) DEFAULT NULL,
  `job` varchar(200) DEFAULT NULL,
  `rue` varchar(250) DEFAULT NULL,
  `ville` varchar(250) DEFAULT NULL,
  `postal` varchar(10) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `note` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wifi`
--

CREATE TABLE `wifi` (
  `idQR` int(11) NOT NULL,
  `wifi` text NOT NULL,
  `password` text NOT NULL,
  `encryption` text NOT NULL,
  `visible` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lien`
--
ALTER TABLE `lien`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `localisation`
--
ALTER TABLE `localisation`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`idQR`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `telephone`
--
ALTER TABLE `telephone`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `RememberIdentifier` (`RememberIdentifier`) USING HASH,
  ADD UNIQUE KEY `RememberToken` (`RememberToken`) USING HASH;

--
-- Index pour la table `vcard`
--
ALTER TABLE `vcard`
  ADD PRIMARY KEY (`idQR`);

--
-- Index pour la table `wifi`
--
ALTER TABLE `wifi`
  ADD PRIMARY KEY (`idQR`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lien`
--
ALTER TABLE `lien`
  ADD CONSTRAINT `lien_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `localisation`
--
ALTER TABLE `localisation`
  ADD CONSTRAINT `localisation_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mail`
--
ALTER TABLE `mail`
  ADD CONSTRAINT `mail_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `qr`
--
ALTER TABLE `qr`
  ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sms`
--
ALTER TABLE `sms`
  ADD CONSTRAINT `sms_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `telephone`
--
ALTER TABLE `telephone`
  ADD CONSTRAINT `telephone_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `text`
--
ALTER TABLE `text`
  ADD CONSTRAINT `text_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vcard`
--
ALTER TABLE `vcard`
  ADD CONSTRAINT `vcard_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wifi`
--
ALTER TABLE `wifi`
  ADD CONSTRAINT `wifi_ibfk_1` FOREIGN KEY (`idQR`) REFERENCES `qr` (`idQR`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
