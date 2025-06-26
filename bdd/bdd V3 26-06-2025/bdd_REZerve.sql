-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 26 juin 2025 à 20:31
-- Version du serveur : 8.0.42-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_REZerve`
--

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `id` int NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Categorie`
--

INSERT INTO `Categorie` (`id`, `nom`) VALUES
(5, 'Meuble'),
(6, 'Electroménager'),
(7, 'Vêtement'),
(8, 'Informatique'),
(9, 'Nourriture'),
(10, 'Divertissement'),
(11, 'Service');

-- --------------------------------------------------------

--
-- Structure de la table `Image`
--

CREATE TABLE `Image` (
  `id` int NOT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'hash de l''image converti en jpg',
  `idObjet` int NOT NULL COMMENT 'Clée étrangère de l''objet',
  `ordre` int NOT NULL COMMENT 'Ordre dans lequelle les images d''un même objet doivent s''afficher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Image`
--

INSERT INTO `Image` (`id`, `hash`, `idObjet`, `ordre`) VALUES
(4, 'a9Tz4LpQcXw82Yb', 5, 1),
(5, 'MkV7dWpLgQ1rXzT', 5, 2),
(6, 'Yc3qNzX84JrKbvF', 3, 1),
(7, 'pTq91MXzRwe6YuD', 3, 2),
(8, 'zL84xPvBcYRm1qA', 3, 3),
(9, 'Qz4rJmA28YTkX6b', 7, 1),
(10, 'dWc3XpV9MqL7zRy', 6, 1),
(11, 'L9XtYwqaZrK83CJ', 6, 2),
(12, 'fB6YmRp2tAVXzKd', 6, 3),
(13, 'aW7Xz3KpVbLq19T', 6, 4),
(14, 'PqKmZRY29xTW48j', 4, 1),
(15, 'xvD4zLKtp8MaqWY', 4, 2),
(16, 'YRpTqzWXMvL983K', 9, 1),
(19, 'XpWKmTzLYRq843v', 14, 1),
(20, 'TzKvWpXY93MLRaQ', 14, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Objet`
--

CREATE TABLE `Objet` (
  `id` int NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idProprietaire` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `typeAnnonce` enum('Don','Pret') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statutObjet` enum('Disponible','Prete','Donne','Archive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idCategorie` int NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `debutPret` date DEFAULT NULL,
  `finPret` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Objet`
--

INSERT INTO `Objet` (`id`, `nom`, `idProprietaire`, `description`, `typeAnnonce`, `statutObjet`, `idCategorie`, `dateCreation`, `debutPret`, `finPret`) VALUES
(3, 'Table basse', 3, 'Table basse de couleur blanche à donner, elle est un peu sale. ', 'Don', 'Disponible', 5, '2025-06-25 18:51:44', NULL, NULL),
(4, 'Four', 4, 'Un four réparé par mes soins, complétement fonctionnel. Vous pourrez y cuire vos meilleurs plats.', 'Don', 'Disponible', 6, '2025-06-25 18:52:57', NULL, NULL),
(5, 'Chemise', 3, 'Chemise en très bon état, taille S. ', 'Don', 'Disponible', 7, '2025-06-25 18:54:02', NULL, NULL),
(6, 'Commode avec tiroirs', 3, 'Je donne ma commode, car je pars bientôt de la résidence ! \r\n\r\n', 'Don', 'Disponible', 5, '2025-06-25 18:55:41', NULL, NULL),
(7, 'Perceuse', 4, 'Je prête ma perceuse, n\'hésitez pas à me contacter !', 'Pret', 'Disponible', 6, '2025-06-25 18:59:24', '2025-07-01', '2025-07-31'),
(9, 'Pomme', 3, 'Je donne ma pomme', 'Don', 'Disponible', 9, '2025-06-26 11:56:28', NULL, NULL),
(13, 'Mallette de poker', 6, 'Je donne ma mallette de poker', 'Don', 'Disponible', 10, '2025-06-26 20:25:50', NULL, NULL),
(14, 'Calculatrice', 3, 'Je prête ma calculatrice CASIO collère ', 'Pret', 'Disponible', 8, '2025-06-26 20:26:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int NOT NULL,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pseudoCLA` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'pseudo de la personne sur le site de CLA, utilisé comme clé entrangère',
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Adresse physique de la personne',
  `facebook` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Lien vers la page Facebook',
  `statutUtilisateur` enum('Etudiant','Association','Modérateur') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `pseudoCLA`, `mail`, `telephone`, `adresse`, `facebook`, `statutUtilisateur`) VALUES
(3, 'BOUCHER', 'Jeanne', 'jeanne.boucher', 'jeanne.boucher@centrale.centralelille.fr', '+33 7 81 71 20 39', 'B103', 'https://www.facebook.com/profile.php?id=61565222811524', 'Etudiant'),
(4, 'GREGOIRE', 'Valentin', 'valentin.gregoire', 'valentin.gregoire@centrale.centralelille.fr', '+33 6 60 18 37 45', 'B210b', 'https://www.facebook.com/profile.php?id=100013626060028', 'Modérateur'),
(6, 'TAN', 'William', 'william.tan', 'william.tan@centrale.centralelille.fr', '+33 7 85 49 25 44', 'Résidence Léonard de Vinci', 'https://www.facebook.com/jose.garciacruz.1650', 'Etudiant');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idObjet` (`idObjet`);

--
-- Index pour la table `Objet`
--
ALTER TABLE `Objet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProprietaire` (`idProprietaire`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Image`
--
ALTER TABLE `Image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `Objet`
--
ALTER TABLE `Objet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Image`
--
ALTER TABLE `Image`
  ADD CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`idObjet`) REFERENCES `Objet` (`id`);

--
-- Contraintes pour la table `Objet`
--
ALTER TABLE `Objet`
  ADD CONSTRAINT `Objet_ibfk_1` FOREIGN KEY (`idProprietaire`) REFERENCES `Utilisateur` (`id`),
  ADD CONSTRAINT `Objet_ibfk_2` FOREIGN KEY (`idCategorie`) REFERENCES `Categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
