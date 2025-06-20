-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2025 at 11:37 AM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vgregoire`
--

-- --------------------------------------------------------

--
-- Table structure for table `Image`
--

CREATE TABLE `Image` (
  `hash` varchar(255) NOT NULL COMMENT 'hash de l''image converti en jpg',
  `isObjet` int(11) NOT NULL COMMENT 'Clée étrangère de l''objet',
  `ordre` int(8) NOT NULL COMMENT 'Ordre dans lequelle les images d''un même objet doivent s''afficher',

  PRIMARY KEY (`hash`),
  FOREIGN KEY (isObjet) REFERENCES Objet(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Image`
--

INSERT INTO `Image` (`hash`, `isObjet`, `ordre`) VALUES
('fauxhash', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Objet`
--

CREATE TABLE `Objet` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` varchar(40) NOT NULL,
  `idProprietaire` int(11) NOT NULL,
  `description` text NOT NULL,
  `typeAnnonce` enum('Don','Prêt') NOT NULL,
  `statutObjet` enum('disponible','prete','donne','archive') NOT NULL,
  `categorieObjet` enum('Meuble','Électroménager','Vêtement','Informatique','Nourriture','Divertissement','Service') NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT current_timestamp(),
  `debutPret` date DEFAULT NULL,
  `finPret` date DEFAULT NULL,

  FOREIGN KEY (idProprietaire) REFERENCES Utilisateur(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Objet`
--

INSERT INTO `Objet` (`id`, `nom`, `idProprietaire`, `description`, `typeAnnonce`, `statutObjet`, `categorieObjet`, `dateCreation`, `debutPret`, `finPret`) VALUES
(1, 'Four', 1, 'Un four réparé par mes soins, complétement fonctionnel', 'Don', 'disponible', 'Électroménager', '2025-06-20 11:36:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `passeHash` varchar(255) NOT NULL COMMENT 'Hash du mot de passe',
  `mail` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(200) NOT NULL COMMENT 'Adresse physique de la personne',
  `facebook` varchar(100) NOT NULL COMMENT 'Lien vers la page Facebook',
  `statutUtilisateur` enum('etudiant','association','moderateur') NOT NULL DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `passeHash`, `mail`, `telephone`, `adresse`, `facebook`, `statutUtilisateur`) VALUES
(1, 'GRÉGOIRE', 'Valentin', '', 'valentin.gregoire@centrale.centralelille.fr', '+33 6 60 18 37 45', 'B210b', 'https://www.facebook.com/profile.php?id=100013626060028', 'moderateur');








/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
