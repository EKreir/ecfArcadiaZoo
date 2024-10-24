-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 21 oct. 2024 à 15:56
-- Version du serveur : 8.0.39-0ubuntu0.24.04.2
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `visiteurs`
--

-- --------------------------------------------------------

--
-- Structure de la table `animal_opinions`
--

CREATE TABLE `animal_opinions` (
  `id` int NOT NULL,
  `animal_id` int DEFAULT NULL,
  `vet_id` int DEFAULT NULL,
  `opinion` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nourriture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grammage` decimal(10,2) DEFAULT NULL,
  `date_passage` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animal_opinions`
--

INSERT INTO `animal_opinions` (`id`, `animal_id`, `vet_id`, `opinion`, `created_at`, `etat`, `nourriture`, `grammage`, `date_passage`) VALUES
(1, 8, 6, NULL, '2024-10-08 13:44:30', 'santé plutôt admirable', 'poissons', 25.00, '2024-10-09'),
(2, 9, 8, NULL, '2024-10-10 09:32:35', 'Assez bien', 'Rongeurs (congelés)', 5.00, '2024-10-10'),
(3, 1, 8, NULL, '2024-10-11 13:56:27', 'En très bonne santé', 'Viande de boeuf', 10.00, '2024-10-11'),
(4, 7, 8, NULL, '2024-10-11 13:57:21', 'Légers troubles musculaires', 'Viande de mouton', 10.00, '2024-10-11');

-- --------------------------------------------------------

--
-- Structure de la table `animaux`
--

CREATE TABLE `animaux` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `habitat_id` int DEFAULT NULL,
  `race` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animaux`
--

INSERT INTO `animaux` (`id`, `name`, `habitat_id`, `race`, `description`, `image`) VALUES
(1, 'Shierkahn', 2, 'Tigre du Bengale', 'Lorem ipsmu.fruthyddvfvf', '../../uploads/Panthera_tigris_tigris.jpg'),
(5, 'Gloria', 8, 'hippopotame', 'rtzgbsrsfnfhndhn', '../../uploads/pexels-roger-brown-3435524-5715383.jpg'),
(6, 'Amelia', 8, 'Flamant rose', 'sgbdqgbwdfbdwbwdbwdbwssss', '../../uploads/flamand-rose-1280x960-2.jpg'),
(7, 'Simba', 9, 'Lion', 'qevqreqevfqdvqfvqfvqvf', '../../uploads/image.jpeg'),
(8, 'All', 8, 'Crocodile', 'sdfgghhhhlgldcvldsvwfdwd wdbwdb', '../../uploads/1309518-Crocodile.jpg'),
(9, 'Ka', 2, 'Serpent python', 'ddefsfqvdfsdbdgbsg', '../../uploads/line-1184810_1280.jpg'),
(10, 'Dumbo', 9, 'Eléphant d\'Afrique', 'qergqerbqdbdqb', '../../uploads/fiche-animale-monde-animal-elephant-savane-afrique.jpg'),
(11, 'Giselle', 9, 'Girafe', 'qffqgbsgnsn', '../../uploads/girafe-augmentation-20.jpg'),
(12, 'Marty', 9, 'Zèbre', 'rutkukfyifukfukf', '../../uploads/zebre.jpg'),
(14, 'Rambo', 9, 'Rhinocéros noir', 'shshdgqqhsrhss', '../../uploads/1435753398.jpg'),
(15, 'Louis', 2, 'Orang-outan', 'sdhsgdhsryhyr', '../../uploads/orang-outan.jpg'),
(16, 'Shen', 2, 'Paon', 'rsthsjdtyjdtyjss', '../../uploads/tout-savoir-sur-le-paon-bel-oiseau-ornement.jpeg'),
(17, 'Encols des singes', 2, 'Singes capucin', 'sduqkqgkdfqbksdgosfg', '../../uploads/capucin-063621.jpg'),
(18, 'Serre des grenouilles', 8, 'Grenouilles arboricole', 'stdhsthqtegbqdfbdqf', '../../uploads/d1819860366702b7ee80dd53baaf752c.jpg'),
(19, 'Territoire des oiseaux', 8, 'Cygnes', 'tgsthshsrhsr', '../../uploads/1309545-Cygne.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `pseudo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_publication` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('en attente','validé','rejeté') COLLATE utf8mb4_general_ci DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `contenu`, `date_publication`, `statut`) VALUES
(18, 'gerard', 'j\'aime', '2024-10-05 17:16:21', 'validé'),
(19, 'pietro', 'incroyable!!', '2024-10-05 17:16:56', 'rejeté'),
(20, 'gregoir', 'l\'eau magnifique', '2024-10-05 17:38:26', 'validé'),
(21, 'axel', 'lions moi aimer', '2024-10-07 15:02:40', 'validé'),
(22, 'daisy', 'fleurs', '2024-10-07 16:46:38', 'rejeté'),
(23, 'lego', 'ninjago', '2024-10-08 09:37:46', 'rejeté'),
(24, 'clara', 'prout', '2024-10-08 12:46:35', 'rejeté'),
(25, 'yael', 'beaux tigres', '2024-10-08 12:47:04', 'validé'),
(26, 'Jay', 'glouglou', '2024-10-10 11:29:38', 'rejeté'),
(27, 'Rico', 'Excellent !', '2024-10-11 15:52:44', 'validé'),
(28, 'pello', 'ciao', '2024-10-16 20:01:24', 'rejeté');

-- --------------------------------------------------------

--
-- Structure de la table `consommation`
--

CREATE TABLE `consommation` (
  `id` int NOT NULL,
  `animal_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `type_nourriture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consommation`
--

INSERT INTO `consommation` (`id`, `animal_id`, `date`, `heure`, `type_nourriture`, `quantite`) VALUES
(1, 7, '2024-12-05', '18:10:00', 'viande de boeuf', 6),
(2, 5, '2024-10-06', '08:04:00', 'Foins', 9),
(3, 6, '2024-10-07', '15:04:00', 'viande de poulet', 1),
(4, 5, '2024-10-08', '09:39:00', 'mélange de feuilles', 10),
(5, 1, '2024-10-08', '10:03:00', 'viande de porc', 5),
(6, 9, '2024-10-10', '11:30:00', 'Souris (congelée)', 5),
(7, 6, '2024-10-11', '15:55:00', 'Crevettes et crustacés', 2);

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

CREATE TABLE `habitats` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `name`, `description`, `image`) VALUES
(2, 'Jungle', 'La jungle d\'Arcadia est une forêt tropicale dense, riche en biodiversité, où la lumière filtre à travers un feuillage épais. Les sons des oiseaux exotiques et des cris des singes créent une atmosphère vibrante. Cet habitat humide et chaud abrite de nombreuses espèces fascinantes.', '../../uploads/pexels-rifkyilhamrd-788200.jpg'),
(8, 'Marais', 'Le marais d\'Arcadia est un écosystème unique, avec des zones d\'eau stagnante et des plantes aquatiques luxuriantes. Ce milieu riche en boue et en humidité attire une variété d\'animaux qui s\'épanouissent dans cette zone humide, offrant aux visiteurs un aperçu fascinant de la vie aquatique et terrestre.', '../../uploads/pexels-quang-nguyen-vinh-222549-2154706.jpg'),
(9, 'Savane', 'La savane d\'Arcadia est un vaste espace ensoleillé, parsemé d\'herbes hautes et d\'acacias, où les visiteurs peuvent observer des animaux majestueux évoluer dans leur environnement naturel. Ce paysage ouvert, ponctué de points d\'eau, offre un habitat idéal pour les espèces qui cohabitent ici.', '../uploads/savane-1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `habitat_comments`
--

CREATE TABLE `habitat_comments` (
  `id` int NOT NULL,
  `habitat_id` int NOT NULL,
  `vet_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `habitat_comments`
--

INSERT INTO `habitat_comments` (`id`, `habitat_id`, `vet_id`, `comment`, `created_at`) VALUES
(1, 8, 8, 'Manque d\'eau pour la réserve animalier', '2024-10-06 07:13:52'),
(2, 2, 8, 'Rajout de plantes nécessaire.', '2024-10-08 07:45:08'),
(4, 9, 8, 'Plus de coins d\'ombres !', '2024-10-10 09:31:53');

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `id` int NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `opening_time`, `closing_time`) VALUES
(1, '10:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `messages_contact`
--

CREATE TABLE `messages_contact` (
  `id` int NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `statut` enum('en attente','traité') COLLATE utf8mb4_general_ci DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reponse` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages_contact`
--

INSERT INTO `messages_contact` (`id`, `titre`, `contenu`, `email`, `statut`, `created_at`, `reponse`) VALUES
(1, 'tarifs', 'combien les billets ?', 'rayler@example.com', 'traité', '2024-10-21 14:32:56', NULL),
(2, 'train touristique', 'est-il très cher ?', 'lorant@test.com', 'traité', '2024-10-21 14:37:05', 'non cela dépend du nombre de personnes et de leur âge.'),
(3, 'Restauration', 'les menus sont-ils toujours les mêmes ?', 'damien@example.com', 'traité', '2024-10-21 14:42:04', 'Non, les chefs changent les menus tous les jours.');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `vet_id` int DEFAULT NULL,
  `animal_id` int DEFAULT NULL,
  `report_text` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`id`, `vet_id`, `animal_id`, `report_text`, `created_at`) VALUES
(7, 6, 7, 'gros crocs', '2024-10-05 19:53:33'),
(8, 6, 5, 'frere', '2024-10-06 05:55:20'),
(9, 6, 7, 'crinière magnifique', '2024-10-06 06:04:51'),
(10, 8, 6, 'petit filou', '2024-10-06 06:58:15'),
(11, 6, 6, 'il lui faut une opération des dents !', '2024-10-07 13:05:23'),
(12, 8, 6, 'a besoin d\'attention', '2024-10-08 07:49:17'),
(13, 6, 1, 'besoin de jouets', '2024-10-08 07:50:58'),
(14, 8, 5, 'soins intensifs', '2024-10-08 07:55:56'),
(15, 8, 9, 'Problème de digestions', '2024-10-10 09:31:30'),
(16, 8, 18, 'Il faut plus d\'humidité !', '2024-10-11 13:55:28');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `image`) VALUES
(1, 'train touristique', 'Montez à bord de notre train touristique pour une exploration relaxante du zoo ! Ce parcours vous emmène à travers nos enclos tout en vous offrant une vue imprenable sur nos magnifiques animaux. Idéal pour les familles ou ceux qui souhaitent se reposer tout en découvrant, le train fait plusieurs arrêts stratégiques pour que vous puissiez explorer à votre rythme. Laissez-vous porter par le charme de notre zoo et profitez d\'une expérience mémorable en toute tranquillité.', 'tourist-train-938568_1280.jpg'),
(2, 'guides touristiques', 'Explorez notre zoo de manière enrichissante avec notre service de guide touristique gratuit ! Nos guides passionnés vous feront découvrir les secrets et anecdotes fascinants sur nos animaux et leur habitat. Que vous soyez un amoureux des animaux ou simplement curieux, cette visite commentée vous permettra de mieux comprendre notre engagement pour la conservation et l\'éducation. Rejoignez-nous à l\'heure des visites pour une aventure inoubliable !', 'pexels-loquellano-17087507.jpg'),
(3, 'Restaurant', 'Découvrez une expérience culinaire unique au cœur de notre zoo. Notre espace de restauration propose une variété de plats savoureux, allant des en-cas rapides aux repas complets, préparés avec des ingrédients frais et locaux. Que vous souhaitiez déguster un délicieux burger, une salade fraîche ou un café réconfortant, notre offre saura satisfaire toutes vos envies. Profitez de votre repas en admirant la nature environnante et en partageant des moments conviviaux en famille ou entre amis.', 'pexels-reneasmussen-1581384.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('employee','vet','admin') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', '$2y$10$ZYi7F9bpNlxrMp9pxN272.ZN0cqg9/sWGiQTAU0hjb2PJ6E4qSJiC', 'admin'),
(5, 'Boris', '$2y$10$FUKrZhU0dGkbEskM8Sv46ubq4Wvr4U.RQDY3JQRdLIRflFwaU4Lp.', 'employee'),
(6, 'Laura', '$2y$10$RhF5no3YmBw5.Kr5o/rDE.RUlYuyTRdf9tHBk42vNLLOCNc5eAC1u', 'vet'),
(7, 'Didier', '$2y$10$fQ3KUSrPq7oEzlyz1/Q59ucRLZg9bnXLHsD2cU0zLhMnS7X92YQp6', 'employee'),
(8, 'Alex', '$2y$10$RV6S6YQ2RgLEOZ3SZvVfF.jLBTTbqxPZMKuTJrhBCM0Jmuldnyv5m', 'vet'),
(9, 'Josselyn', '$2y$10$TU6U9QUAYz7VvV9AdUiOpep9aGO7X2kKtXMgAfcLhnPE0Jx450zCy', 'employee');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animal_opinions`
--
ALTER TABLE `animal_opinions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- Index pour la table `animaux`
--
ALTER TABLE `animaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `habitats`
--
ALTER TABLE `habitats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vet_id` (`vet_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animal_opinions`
--
ALTER TABLE `animal_opinions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `animaux`
--
ALTER TABLE `animaux`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `consommation`
--
ALTER TABLE `consommation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animal_opinions`
--
ALTER TABLE `animal_opinions`
  ADD CONSTRAINT `animal_opinions_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`),
  ADD CONSTRAINT `animal_opinions_ibfk_2` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `animaux`
--
ALTER TABLE `animaux`
  ADD CONSTRAINT `animaux_ibfk_1` FOREIGN KEY (`habitat_id`) REFERENCES `habitats` (`id`);

--
-- Contraintes pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD CONSTRAINT `consommation_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`);

--
-- Contraintes pour la table `habitat_comments`
--
ALTER TABLE `habitat_comments`
  ADD CONSTRAINT `habitat_comments_ibfk_1` FOREIGN KEY (`habitat_id`) REFERENCES `habitats` (`id`),
  ADD CONSTRAINT `habitat_comments_ibfk_2` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
