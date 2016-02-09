-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 09 Février 2016 à 13:09
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bourse`
--

-- --------------------------------------------------------

--
-- Structure de la table `societe`
--

CREATE TABLE IF NOT EXISTS `societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomSociete` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `representant` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `niveauAccess` enum('-1','0','1','2','9') COLLATE utf8_unicode_ci NOT NULL COMMENT 'niveau d''acces d''utilisateur 0 utilisateur  non validé ,1 utilisateur validé ,9 admin -1 utilisateur decactivé ',
  `dateInscription` date NOT NULL,
  `confirmation_token` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed_at` date DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=104 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `login`, `password`, `email`, `niveauAccess`, `dateInscription`, `confirmation_token`, `confirmed_at`, `token`) VALUES
(27, 'yes', 'yes', 'admin1', '$2y$10$sCbd9x6I3CMufhn99awzNuhzxDax7tgxsPhUDq2CTH.E15tKTo/ZK', 'lilou2008@live.fr', '-1', '2016-01-21', NULL, NULL, NULL),
(39, 'azerty', 'ZZzSS', 'admin11447', '$2y$10$bOYpnLkqM.GBpf9bvYMhKumucQ8qzW2xSCkKLApeGYHbKa3oGG4Ve', 'azert@az.de', '0', '2016-01-21', NULL, NULL, NULL),
(42, 'admin', 'ZZzSS', 'admin1144', '$2y$10$OdjXOjSNDyqREiE.axpmHumi7e0pSWbr.kLZnktTLN5bnRaPg58Ye', 'hociiine@hotmail.fr', '0', '2016-01-21', NULL, NULL, NULL),
(66, 'szza', 'qaaa', 'qzzde', '$2y$10$8uXOYJYa3jAkJzeVvcR1VuvDpvJYf3S3bP3dRBOv9b4l0iRHAgMny', 'samirabelarbi@laposte.net', '0', '2016-01-26', NULL, NULL, NULL),
(103, 'samira', 'samira', 'root', '$2y$10$r.4cCEcdSaC6WhgFwpFKCeTtp55kEfgQgL.NxfFgTmA2fU0hhLlFa', 'samirabelarbi@laposte.nat', '9', '2016-02-09', '$2y$10$STbJc0Qjd6foMV/p.RlcQOLs0DqJBi3T3xCaIOPjVJYLCiAtpduxS', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
