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
  `ordre` int(8) NOT NULL COMMENT 'Ordre dans lequelle les images d''un même objet doivent s''afficher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Image`
--

-- --------------------------------------------------------

--
-- Table structure for table `Objet`
--

CREATE TABLE `Objet` (
  `id` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `idProprietaire` int(11) NOT NULL,
  `description` text NOT NULL,
  `typeAnnonce` enum('Don','Prêt') NOT NULL,
  `statutObjet` enum('disponible','prete','donne','archive') NOT NULL,
  `categorieObjet` enum('Meuble','Électroménager','Vêtement','Informatique','Nourriture','Divertissement','Service') NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT current_timestamp(),
  `debutPret` date DEFAULT NULL,
  `finPret` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Objet`
--

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`hash`);

--
-- Indexes for table `Objet`
--
ALTER TABLE `Objet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Objet`
--
ALTER TABLE `Objet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
