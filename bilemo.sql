-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 21 juil. 2020 à 17:10
-- Version du serveur :  8.0.20
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bilemo`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `firstname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_number` int NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` int NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `user_id`, `firstname`, `lastname`, `email`, `street_number`, `street`, `cp`, `city`, `phone_number`) VALUES
(1, 1, 'Daniel', 'Grondin', 'daniel.grondin@ac-nantes.fr', 6, 'barriere de saumur', 85200, 'Fontenay', '0606060606'),
(37, 1, 'Claire', 'Durand', 'claire.durand@sfr.fr', 12, 'Route de Paris', 85200, 'Fontenay', '0606060606'),
(38, 1, 'Julia', 'Dupond', 'julia.d@orange.fr', 4, 'Rue des roses', 85200, 'Fontenay', '0606060606'),
(39, 1, 'Thomas', 'Laurent', 'thom.l@free.fr', 9, 'Rue du poirrier', 85200, 'Fontenay', '0606060606'),
(40, 1, 'Céline', 'Betho', 'celine.bertho@orange.fr', 57, 'Rue des champs', 85200, 'Fontenay', '0606060606'),
(41, 1, 'Simon', 'Deschamps', 'simon.deschamps@gmail.com', 57, 'Rue de Paris', 85200, 'Fontenay', '0606060606'),
(42, 1, 'Elsa', 'Franck', 'elsa.franck@gmail.com', 1, 'Rue Victor Hugo', 85200, 'Fontenay', '0606060606'),
(43, 1, 'Eric', 'Lamy', 'eric.lamy@gmail.com', 145, 'Rue Victor Hugo', 85200, 'Fontenay', '0606060606'),
(46, 1, 'Anne', 'Lorien', 'anne.lorien@ac-nantes.fr', 14, 'rue des hors', 85200, 'Fontenay', '0606060606');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200629162711', '2020-06-29 16:27:20', 63),
('DoctrineMigrations\\Version20200630152812', '2020-06-30 15:28:22', 178),
('DoctrineMigrations\\Version20200630200119', '2020-06-30 20:01:26', 192),
('DoctrineMigrations\\Version20200721123352', '2020-07-21 12:34:02', 103);

-- --------------------------------------------------------

--
-- Structure de la table `phone`
--

CREATE TABLE `phone` (
  `id` int NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `phone`
--

INSERT INTO `phone` (`id`, `name`, `ref`, `price`, `designation`, `stock`) VALUES
(1, 'Iphone X', 'ipxA1', 999, 'iphone anniversary', 27),
(2, 'Iphone 11', 'ip11A43', 1210, 'iphone for photos and video 4K', 13),
(3, 'Iphone 11 pro', 'ip11p43', 1310, 'iphone for photos and video 4K for professionnels', 18),
(4, 'Galaxy S20', 'galasp20', 910, 'galaxy for photos and video 4K the top for Android', 29),
(5, 'Huawei P40', 'huap4', 810, 'Huawei smartphone for photos and video 4K. Best price', 39),
(6, 'Huawei P39', 'huap3', 610, 'Huawei smartphone for photos and video hd. Best price', 59),
(7, 'Galaxy S19', 'Galax19', 510, 'Galxy S19 smartphone for photos and video hd. Best price', 44);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'phone_market', '{\"ROLES\": \"ROLE_ADMIN\"}', '$argon2id$v=19$m=65536,t=4,p=1$LWUqhb1pGHyi8ZffYKHSkQ$Al7oqj6Z5JW7BIlBhuC7ifp0LGkcMxQKMl16Z0j4ba8'),
(2, 'root', '{\"ROLES\": \"ROLE_ROOT\"}', '$argon2id$v=19$m=65536,t=4,p=1$LWUqhb1pGHyi8ZffYKHSkQ$Al7oqj6Z5JW7BIlBhuC7ifp0LGkcMxQKMl16Z0j4ba8');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C7440455A76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `phone`
--
ALTER TABLE `phone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C7440455A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
