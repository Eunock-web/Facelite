-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 23 juil. 2025 à 13:52
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `facelite`
--

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

CREATE TABLE `amis` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ami_id` int(11) NOT NULL,
  `statut` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`id`, `user_id`, `ami_id`, `statut`, `created_at`, `updated_at`) VALUES
(22, 59, 66, 'accepted', '2025-07-18 02:22:21', '2025-07-18 02:22:48');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 9, 59, 'Itachi le goat', '2025-07-09 08:14:31'),
(2, 9, 59, 'Sacrifie son clan pour Konoha', '2025-07-09 08:15:04'),
(3, 6, 59, 'opening Naruo', '2025-07-09 08:16:15'),
(4, 9, 59, 'un goat', '2025-07-11 09:07:40'),
(5, 9, 59, 'un aure', '2025-07-11 11:54:41'),
(6, 8, 59, 'Zenitsu en flow mode', '2025-07-12 03:37:44'),
(7, 11, 66, 'sukuna', '2025-07-14 05:22:25'),
(8, 10, 59, 'zenitsu', '2025-07-14 11:04:01');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('private','group') DEFAULT 'private',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(2, NULL, 'private', '2025-07-18 02:23:56', '2025-07-18 02:28:52');

-- --------------------------------------------------------

--
-- Structure de la table `conversation_participants`
--

CREATE TABLE `conversation_participants` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conversation_participants`
--

INSERT INTO `conversation_participants` (`id`, `conversation_id`, `user_id`, `role`, `joined_at`, `last_read_at`) VALUES
(3, 2, 59, 'member', '2025-07-18 02:23:56', '2025-07-18 02:32:57'),
(4, 2, 66, 'member', '2025-07-18 02:23:56', '2025-07-18 18:07:17');

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `user_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `hometown` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `graduation_year` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `visibility` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `relationship_status` enum('single','in_relationship','married','complicated') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `show_email` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `informations`
--

INSERT INTO `informations` (`user_id`, `bio`, `website`, `location`, `hometown`, `job_title`, `company`, `education`, `graduation_year`, `phone`, `visibility`, `birth_date`, `gender`, `relationship_status`, `created_at`, `updated_at`, `show_email`) VALUES
(59, 'Id consequatur place', '', '', '', '', '', '', 0, '+1 (897) 534-6451', 'private', '0000-00-00', '', '', '2025-07-17 17:30:23', '2025-07-17 18:20:18', 1);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(16, 59, 6, '2025-07-10 11:19:48'),
(17, 59, 5, '2025-07-10 11:19:54'),
(18, 59, 7, '2025-07-10 11:20:50'),
(29, 59, 8, '2025-07-12 03:20:23'),
(34, 59, 9, '2025-07-12 03:31:27'),
(35, 59, 10, '2025-07-14 01:19:56'),
(36, 66, 12, '2025-07-14 04:24:02'),
(37, 66, 9, '2025-07-14 04:24:11'),
(39, 59, 4, '2025-07-14 11:03:28'),
(40, 59, 11, '2025-07-14 11:03:36'),
(41, 59, 12, '2025-07-14 11:03:40');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `message_type` enum('text','image','video','file') DEFAULT 'text',
  `file_url` varchar(500) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `content`, `message_type`, `file_url`, `is_deleted`, `created_at`) VALUES
(21, 2, 66, 'YO', 'text', NULL, 0, '2025-07-18 02:28:38'),
(22, 2, 59, 'Bien?', 'text', NULL, 0, '2025-07-18 02:28:52');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` enum('friend_request','friend_accepted','like','comment','mention') NOT NULL,
  `content` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `from_user_id`, `post_id`, `type`, `content`, `is_read`, `created_at`) VALUES
(1, 59, 59, 11, '', 'Vous avez publié un nouveau post', 0, '2025-07-14 01:28:23'),
(16, 59, 66, NULL, 'friend_request', 'AIHOUNHIN Eunock vous a envoyé une demande d\'amitié', 1, '2025-07-14 04:04:22'),
(17, 66, 59, NULL, 'friend_accepted', 'YAGAMI Light a accepté votre demande d\'amitié', 1, '2025-07-14 04:05:12'),
(18, 66, 66, 12, '', 'Vous avez publié un nouveau post', 1, '2025-07-14 04:11:14'),
(19, 59, 66, 12, '', 'a publié un nouveau post', 1, '2025-07-14 04:11:14'),
(20, 59, 66, 9, 'like', 'AIHOUNHIN Eunock a aimé votre publication', 1, '2025-07-14 04:24:11'),
(21, 59, 66, 11, 'comment', 'AIHOUNHIN Eunock a commenté votre publication', 1, '2025-07-14 05:22:25'),
(22, 66, 59, 12, 'like', 'YAGAMI Light a aimé votre publication', 1, '2025-07-14 07:43:42'),
(23, 66, 59, 12, 'like', 'YAGAMI Light a aimé votre publication', 1, '2025-07-14 11:03:40'),
(24, 59, 66, NULL, 'friend_request', 'AIHOUNHIN Eunock vous a envoyé une demande d\'amitié', 1, '2025-07-18 01:41:26'),
(25, 66, 59, NULL, 'friend_request', 'Light YAGAMI vous a envoyé une demande d\'amitié', 1, '2025-07-18 02:22:21'),
(26, 59, 66, NULL, 'friend_accepted', 'AIHOUNHIN Eunock a accepté votre demande d\'amitié', 1, '2025-07-18 02:22:48');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `description` text DEFAULT NULL,
  `type_post` enum('texte','video','image') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `content`, `description`, `type_post`, `created_at`) VALUES
(2, 59, '1722691528003.jpg', 'une image', 'video', '2025-07-06 15:55:36'),
(3, 59, '1722691370997.jpg', 'une autre image', 'video', '2025-07-07 01:29:44'),
(4, 59, '/assets/imagePost/post_686b08de6e6d4_59.jpg', 'une image', 'image', '2025-07-07 01:38:06'),
(5, 59, '/assets/imagePost/post_686b885b2a90b_59.jpg', 'une image', 'image', '2025-07-07 10:42:03'),
(6, 59, '/assets/videoPost/post_686b8b4f32460_59.mp4', 'une autre image', 'video', '2025-07-07 10:54:39'),
(7, 59, '/assets/imagePost/post_686bb1f204c6e_59.jpg', 'une image', 'image', '2025-07-07 13:39:30'),
(8, 59, '/assets/imagePost/post_686d018320ec4_59.jpg', 'Itachi le goat', 'image', '2025-07-08 13:31:15'),
(9, 59, '/assets/imagePost/post_686d35241cd65_59.jpg', 'Itachi le goat', 'image', '2025-07-08 17:11:32'),
(10, 59, '/assets/imagePost/post_687458d460210_59.jpg', 'une autre image', 'image', '2025-07-14 03:09:40'),
(11, 59, '/assets/imagePost/post_68745d3736a58_59.jpg', 'Un exemple', 'image', '2025-07-14 03:28:23'),
(12, 66, '/assets/imagePost/post_68748362b831b_66.jpg', 'Post de Eunock', 'image', '2025-07-14 06:11:14');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `profil` varchar(255) NOT NULL,
  `couverture` varchar(255) DEFAULT NULL,
  `code_verification` int(11) NOT NULL,
  `code_expiry` datetime DEFAULT NULL,
  `is_validated` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `birthday`, `password`, `genre`, `profil`, `couverture`, `code_verification`, `code_expiry`, `is_validated`, `created_at`) VALUES
(59, 'Light', 'YAGAMI', 'daho@mailinator.com', '2025-03-14', '$2y$10$LEFK2SrNXN00HOip7GPD3.U5KXzPbsL.31m.l83yuu8apSVAhb3s.', 'Masculin', 'assets/profil/1.jpg', 'assets/profil/1.jpg', 794579, '2025-07-07 13:00:36', 1, '2025-07-17 18:20:18'),
(66, 'AIHOUNHIN', 'Eunock', 'erwinmith768@gmail.com', '2000-07-26', '$2y$10$i0FLyRSilUb1NMF.sc8o4eDu/Ile3UVIy8L1xssmnMD/.oXhyVUD.', 'Masculin', 'assets/profil/687501755bcb9.jpg', 'assets/couverture/6874fcd0eee20.jpg', 0, '2025-07-14 06:08:26', 1, '2025-07-18 16:01:11');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `amis`
--
ALTER TABLE `amis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ami` (`user_id`,`ami_id`),
  ADD KEY `ami_id` (`ami_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_participant` (`conversation_id`,`user_id`),
  ADD KEY `idx_conversation_participants_user` (`user_id`),
  ADD KEY `idx_conversation_participants_conversation` (`conversation_id`);

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD UNIQUE KEY `unique_user_profile` (`user_id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `amis`
--
ALTER TABLE `amis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`ami_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Contraintes pour la table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `informations`
--
ALTER TABLE `informations`
  ADD CONSTRAINT `informations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
