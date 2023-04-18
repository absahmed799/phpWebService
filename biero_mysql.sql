-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost

-- Version du serveur :  5.6.28-0ubuntu0.15.04.1
-- Version de PHP :  5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `biero`
--
CREATE DATABASE IF NOT EXISTS `biero` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `biero`;

-- --------------------------------------------------------

--
-- Structure de la table `biere`
--

DROP TABLE IF EXISTS `biere`;
CREATE TABLE IF NOT EXISTS `biere` (
`id_biere` int(11) NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `brasserie` varchar(200) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` date DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
`id_commmentaire` int(11) NOT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_biere` int(11) NOT NULL,
  `id_usager` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
`id_note` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `id_biere` int(11) NOT NULL,
  `id_usager` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `usager`
--

DROP TABLE IF EXISTS `usager`;
CREATE TABLE IF NOT EXISTS `usager` (
`id_usager` int(11) NOT NULL,
  `courriel` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `biere`
--
ALTER TABLE `biere`
 ADD PRIMARY KEY (`id_biere`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
 ADD PRIMARY KEY (`id_commmentaire`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
 ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `usager`
--
ALTER TABLE `usager`
 ADD PRIMARY KEY (`id_usager`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `biere`
--
ALTER TABLE `biere`
MODIFY `id_biere` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
MODIFY `id_commmentaire` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `usager`
--
ALTER TABLE `usager`
MODIFY `id_usager` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
