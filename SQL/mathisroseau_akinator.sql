-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : mar. 18 fév. 2025 à 21:05
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mathisroseau_akinator`
--

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `response` enum('Oui','Non') NOT NULL,
  `next_question` int(11) DEFAULT NULL,
  `questions_id` int(11) DEFAULT NULL,
  `result_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `answers`
--

INSERT INTO `answers` (`id`, `response`, `next_question`, `questions_id`, `result_id`) VALUES
(1, 'Oui', 2, 1, NULL),
(2, 'Non', 5, 1, NULL),
(3, 'Oui', 3, 2, NULL),
(4, 'Non', 4, 2, NULL),
(5, 'Oui', NULL, 3, 1),
(6, 'Non', NULL, 3, 2),
(7, 'Oui', NULL, 4, 3),
(8, 'Non', NULL, 4, 4),
(9, 'Oui', 6, 5, NULL),
(10, 'Non', 9, 5, NULL),
(11, 'Oui', 7, 6, NULL),
(12, 'Non', 8, 6, NULL),
(13, 'Oui', NULL, 7, 5),
(14, 'Non', NULL, 7, 6),
(15, 'Oui', NULL, 8, 7),
(16, 'Non', NULL, 8, 8),
(17, 'Oui', NULL, 9, 9),
(18, 'Non', NULL, 9, 10);

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `result` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `result_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `Text` text NOT NULL,
  `is_first_question` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `Text`, `is_first_question`) VALUES
(1, 'Le personnage utilise-t-il une arme blanche ?', 1),
(2, 'Est-ce une femme ?', 0),
(3, 'Son arme est un katana ?', 0),
(4, 'Peut-il voler ?', 0),
(5, 'Utilise une sorte de magie ?', 0),
(6, 'Provient-il d’un manga ?', 0),
(7, 'Utilise-t-il l’infini ?', 0),
(8, 'Est-il l’esprit démoniaque ?', 0),
(9, 'Utilise-t-il des gants de boxe ?', 0);

-- --------------------------------------------------------

--
-- Structure de la table `result`
--

CREATE TABLE `result` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `result`
--

INSERT INTO `result` (`id`, `name`, `description`, `picture`) VALUES
(1, 'Miko', 'Un personnage maniant un katana.', 'miko.png'),
(2, 'Lunatic', 'Un personnage combattant sans katana.', 'lunatic.png'),
(3, 'Fallen', 'Un personnage qui peut voler.', 'fallen.png'),
(4, 'Seigen', 'Un personnage qui ne peut pas voler.', 'seigen.png'),
(5, 'The Strongest Sorcerer/ GOJO', 'Un personnage maîtrisant l\"infini.', 'gojo.png'),
(6, 'The King of Curses/ Sukuna', 'Un roi des malédictions.', 'sukuna.png'),
(7, 'Shin Goren', 'Un esprit démoniaque.', 'shin_goren.png'),
(8, 'Goren', 'Un personnage ordinaire.', 'goren.png'),
(9, 'Wonderboy', 'Un boxeur utilisant des gants.', 'wonderboy.png'),
(10, 'Nakmuay', 'Un combattant sans gants.', 'nakmuay.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Emma', 'Emma@test.com', '$2y$10$jBM2odiVho8f6I9IHJjGfO9QvdPjOo/O6HShk2rOaVxdF6m20QlNq'),
(2, 'Jade', 'jade@test.com', '$2y$10$9UmXRmOP3s./WjDUXHKWou4ZimE5PuIudDRUzW1ydd0tYt19rExta');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `answers_question_response_unique` (`questions_id`,`response`),
  ADD UNIQUE KEY `answers_question_response_uniques` (`questions_id`,`response`),
  ADD KEY `fk_answers_result` (`result_id`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_users` (`users_id`),
  ADD KEY `fk_game_result` (`result_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `result`
--
ALTER TABLE `result`
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
-- AUTO_INCREMENT pour la table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answers_questions` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_answers_result` FOREIGN KEY (`result_id`) REFERENCES `result` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `fk_game_result` FOREIGN KEY (`result_id`) REFERENCES `result` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_game_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
