-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2025 at 05:26 PM
-- Server version: 8.0.42-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

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
  `id` int NOT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'hash de l''image converti en jpg',
  `idObjet` int NOT NULL COMMENT 'Clée étrangère de l''objet',
  `ordre` int NOT NULL COMMENT 'Ordre dans lequelle les images d''un même objet doivent s''afficher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Image`
--

INSERT INTO `Image` (`id`, `hash`, `idObjet`, `ordre`) VALUES
(1, 'fauxhash', 1, 1),
(2, 'table_basse_1', 2, 1),
(3, 'table_basse_2', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Objet`
--

CREATE TABLE `Objet` (
  `id` int NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idProprietaire` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `typeAnnonce` enum('Don','Prêt') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statutObjet` enum('disponible','prete','donne','archive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `categorieObjet` enum('Meuble','Électroménager','Vêtement','Informatique','Nourriture','Divertissement','Service') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `debutPret` date DEFAULT NULL,
  `finPret` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Objet`
--

INSERT INTO `Objet` (`id`, `nom`, `idProprietaire`, `description`, `typeAnnonce`, `statutObjet`, `categorieObjet`, `dateCreation`, `debutPret`, `finPret`) VALUES
(1, 'Four', 1, 'Un four réparé par mes soins, complétement fonctionnel', 'Don', 'disponible', 'Électroménager', '2025-06-20 11:36:34', NULL, NULL),
(2, 'Table', 2, 'Table basse à donner', 'Don', 'disponible', 'Meuble', '2025-06-20 18:12:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `passeHash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Hash du mot de passe',
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Adresse physique de la personne',
  `facebook` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Lien vers la page Facebook',
  `statutUtilisateur` enum('etudiant','association','moderateur') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `passeHash`, `mail`, `telephone`, `adresse`, `facebook`, `statutUtilisateur`) VALUES
(1, 'GRÉGOIRE', 'Valentin', '', 'valentin.gregoire@centrale.centralelille.fr', '+33 6 60 18 37 45', 'B210b', 'https://www.facebook.com/profile.php?id=100013626060028', 'moderateur'),
(2, 'BOUCHER', 'Jeanne', '', 'jeanne.boucher@centrale.centralille.fr', '+33 7 81 71 20 39', 'B103', 'https://www.facebook.com/profile.php?id=61565222811524', 'etudiant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idObjet` (`idObjet`);

--
-- Indexes for table `Objet`
--
ALTER TABLE `Objet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProprietaire` (`idProprietaire`);

--
-- Indexes for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Image`
--
ALTER TABLE `Image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Objet`
--
ALTER TABLE `Objet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Image`
--
ALTER TABLE `Image`
  ADD CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`idObjet`) REFERENCES `Objet` (`id`);

--
-- Constraints for table `Objet`
--
ALTER TABLE `Objet`
  ADD CONSTRAINT `Objet_ibfk_1` FOREIGN KEY (`idProprietaire`) REFERENCES `Utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
