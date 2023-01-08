-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 08 jan. 2023 à 15:24
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rennes-pwtpsafer-db`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'Terrain agricole', '2023-01-01 00:00:00', NULL),
(2, 'Prairies', '2023-01-01 00:00:00', NULL),
(3, 'Bois', '2023-01-01 00:00:00', NULL),
(4, 'Batiments', '2023-01-01 00:00:00', NULL),
(5, 'Exploitations', '2023-01-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221129163014', '2023-01-06 20:03:29', 91),
('DoctrineMigrations\\Version20221219154319', '2023-01-06 20:03:29', 40),
('DoctrineMigrations\\Version20221219171847', '2023-01-06 20:03:29', 225),
('DoctrineMigrations\\Version20221221144438', '2023-01-06 20:03:29', 137),
('DoctrineMigrations\\Version20221221145010', '2023-01-06 20:03:29', 19),
('DoctrineMigrations\\Version20221226174555', '2023-01-06 20:03:29', 192),
('DoctrineMigrations\\Version20221227093046', '2023-01-06 20:03:30', 133),
('DoctrineMigrations\\Version20221227172610', '2023-01-06 20:03:30', 39),
('DoctrineMigrations\\Version20221227172817', '2023-01-06 20:03:30', 19),
('DoctrineMigrations\\Version20221227173016', '2023-01-06 20:03:30', 59),
('DoctrineMigrations\\Version20230105191227', '2023-01-06 20:03:30', 45),
('DoctrineMigrations\\Version20230106144620', '2023-01-06 20:03:30', 12);

-- --------------------------------------------------------

--
-- Structure de la table `favourite`
--

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL,
  `bien_id_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_sent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `favourite`
--

INSERT INTO `favourite` (`id`, `bien_id_id`, `email`, `created_at`, `is_sent`) VALUES
(22, 30, 'test@test.test', '2023-01-08 15:09:15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `property_id_id` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `category_id_id` int(11) NOT NULL,
  `added_by_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surface` double DEFAULT NULL,
  `price` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `property`
--

INSERT INTO `property` (`id`, `category_id_id`, `added_by_id`, `title`, `surface`, `price`, `description`, `country`, `postal_code`, `type`, `created_at`, `updated_at`, `image`, `owner`, `reference`) VALUES
(1, 4, NULL, 'Activites Equestres, Apiculture, Chasse,', 17, 330000, 'Propriete Charente-Maritime', '17200', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '1703017'),
(2, 4, NULL, 'FERME 100% HERBAGERE/ ELEVAGE LAITIER', 34, 950, 'Situee e l\'oree d\'un bourg, e 10 minutes des services et commerces', '35200', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '1907118'),
(3, 2, NULL, 'Propriete Creuse', 1, 860, 'Dans un hameau e moins de 10 minutes d\'un bourg avec services et commerces, et d\'un village ayant un interet touristique sur les routes de St-Jacques-de-Compostelle.', '23320', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '2316104'),
(4, 4, NULL, 'Propriete Gard', 29, 2000, 'Ensemble immobilier proche d\'un plan d\'eau amenage', '34290', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '30VI9700'),
(5, 3, NULL, 'Ideal societe de chasse', 35, 120000, 'Terrain boise classe ONF', '22700', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '313453DR'),
(6, 3, NULL, 'Sapiniere', 1, 800, 'Sapiniere en cours de bail, cherche reprise', '35200', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '344334UJ'),
(7, 3, NULL, 'Bois sur pied', 6, 30000, 'Diverses essences sur place', '29510', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '345E7EG'),
(8, 2, NULL, 'Tourisme rural-hebergement', 1, 1, 'Au nord de l\'Herault, proche des axes routiers et e 45 minutes de Montpellier', '34070', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '34AG10897'),
(9, 2, NULL, 'Propriete viticole et sa cave', 30, 1, 'Au ceur de l\'appellation Saint-Chinian', '34280', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '34VI6979'),
(10, 5, NULL, 'Vallons du Voironnais', 13, 2000, '13 Ha de terrain', '38500', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '38TB22187'),
(11, 1, NULL, 'Prairies en pays glazik', 1, 15000, 'Usage petits animaux type caprins', '29510', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '43LM220118'),
(12, 2, NULL, 'Betiments avicoles e transmettre', 2, 200000, 'Site avicole e transmettre sur la commune de Nort-sur-Erdre, au nord de Nantes.', '44220', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '44 22 AN 08'),
(13, 5, NULL, 'PRET A USAGE sur 95 ha - PLAINE DES VOSGES ', 14, 11000, ' A 5 min de Villeneuve-sur-Lot', '47300', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '47.06.098'),
(14, 2, NULL, 'Propriete Lozere', 1, 700, 'Ensemble beti avec environ 1ha55', '48370', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '48EL11345'),
(15, 5, NULL, 'Situe e 15 minutes de Mende', 10, 1300, 'ideal pour polyculture sur 14 ha', '30430', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '48RE11201'),
(16, 4, NULL, 'Propriete Meuse', 59, 0, 'FERME DE COURUPT : Secteur Sainte-Menehould / Clermont-en-Argonne / Revigny', '88340', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '55VS'),
(17, 5, NULL, 'Ancienne ferme equestre en ruine', 12, 156000, 'Terrains actuellement loues', '29510', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '5667DB'),
(18, 1, NULL, 'Productions vegetales', 2, 7700, 'La parcelle se situe dans le Bearn sur la commune de LAGOR.', '64150', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '64.02.59'),
(19, 2, NULL, 'Propriete situee dans un secteur vallonne', 6, 650, 'Propriete Pyrenees-Atlantiques', '23500', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '64.03.60'),
(20, 3, NULL, 'Terrain classe T4', 1, 500, 'cloture et partiellement boise', '56500', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '65.23.876'),
(21, 1, NULL, 'Prairies sur les plateaux', 76, 400000, 'Parcelle de terre labourable d\'environ 2 ha', '81090', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '7629CA'),
(22, 1, NULL, 'Prairies orientees nord ouest', 11, 113000, 'Lot d\'un seul tenant', '56500', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '765DN'),
(23, 1, NULL, 'Terrain proche cours d\'eau', 5, 3000, 'Non accessible par la route, uniquement chemin d\'exploitation', '35200', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '76RZDC'),
(24, 3, NULL, 'Secteur du Segala-Viaur', 54, 400000, 'les secteurs les plus en pente sont empieres', '12200', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '81EL11100'),
(25, 5, NULL, 'Vittel Dombrot : Ouest vosgien, secteur de VITTEL', 6, 0, 'Terrains d\'environ 6,5 ha', '88170', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '88 FB '),
(26, 1, NULL, 'Terrain avec abri', 1, 1200, 'Pour proprietaire equin', '44110', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', '9875RDC'),
(27, 4, NULL, 'Exploitation Agricole specialisee en polyculture elevage', 87, 0, 'Exploitation situee dans le Sud Est de La Sarthe, entre la commune d\'Ecommoy (72220) et Sarce (72327)', '72220', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', 'AA 72 22 0088 R'),
(28, 4, NULL, 'Propriete Calvados', 17, 173, 'JFD : Noue de Sienne (14)', '14380', NULL, 'Vente', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', 'MQ14170356 '),
(29, 3, NULL, 'Bois domainial', 32, 12000, 'Bois accessible avec sentiers', '44110', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', 'QDSGF56'),
(30, 1, NULL, 'Legerement en Pente', 3, 2400, 'Ideal paturage moutons', '22700', NULL, 'Location', '0000-00-00 00:00:00', NULL, '34AG10897.jpg', 'John Doe', 'Z34.345.45'),
(32, 2, 1, 'Test', 15, 15, 'Lore Lore Lore Lore', 'Paris', '25000', 'vente', '2023-01-08 14:18:18', NULL, 'bedroom-g5b16b22f8-1920-63bac29b9424d.jpg', 'Jean', 'QECUEXB6');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `searched_property`
--

CREATE TABLE `searched_property` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minprice` int(11) DEFAULT NULL,
  `maxprice` int(11) DEFAULT NULL,
  `minsurface` int(11) DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `maxsurface` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `searched_property`
--

INSERT INTO `searched_property` (`id`, `type`, `minprice`, `maxprice`, `minsurface`, `country`, `created_at`, `maxsurface`, `name`, `email`) VALUES
(2, 'location', 150, 3000, 50, 'Paris', '2023-01-08 13:41:15', 250, 'jean de Dieu', 'monadresse@gmail.com'),
(3, 'location', 50, 180, 50, 'Paris', '2023-01-08 14:02:20', 600, 'jean de Dieu', 'aa@aa.aa'),
(4, 'location', 50, 300, 50, 'Paris', '2023-01-08 14:15:58', 500, 'Wilfrand', 'wilf@aa.aa'),
(5, 'vente', 50, 800, 15, 'Rennes', '2023-01-08 15:10:24', 900, 'Wilfrand', 'aa@aa.aa');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `created_at`, `updated_at`) VALUES
(1, 'admin@safer.com', '[\"ROLE_ADMIN\"]', '$2y$13$5tP3ZDAiCpFQqct9FKENuOighbxem7x3jGfH9iBYn7y/x2UjMWUzi', 'FIST', 'NAZ', NULL, NULL),
(2, 'atchiwilfrand@safer.com', '[\"ROLE_ADMIN\"]', '$2y$13$ti4WHVem4BRiRLqSc77tEuMaODo2yD.GgVGmd4DWUV8SU7U/XlFDe', 'Wilfrand', 'ATCHI', NULL, NULL),
(3, 'mbarach@safer.com', '[\"ROLE_ADMIN\"]', '$2y$13$Kq2juzlgAW1PEccY4gwq7eBmdMaMGHL3HYbk.jzGkvR6yjWP.8JkG', 'Maël', 'BARAC\'H', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A2CA19C164C1CB` (`bien_id_id`);

--
-- Index pour la table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_472B783AB9575F5A` (`property_id_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8BF21CDE9777D11E` (`category_id_id`),
  ADD KEY `IDX_8BF21CDE55B127A4` (`added_by_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `searched_property`
--
ALTER TABLE `searched_property`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `favourite`
--
ALTER TABLE `favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `searched_property`
--
ALTER TABLE `searched_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `FK_62A2CA19C164C1CB` FOREIGN KEY (`bien_id_id`) REFERENCES `property` (`id`);

--
-- Contraintes pour la table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `FK_472B783AB9575F5A` FOREIGN KEY (`property_id_id`) REFERENCES `property` (`id`);

--
-- Contraintes pour la table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `FK_8BF21CDE55B127A4` FOREIGN KEY (`added_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_8BF21CDE9777D11E` FOREIGN KEY (`category_id_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
