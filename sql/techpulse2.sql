-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 fév. 2025 à 09:43
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
-- Base de données : `techpulse2`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaires` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_produits` int(11) NOT NULL,
  `notation` int(11) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `messages` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaires`, `id_users`, `id_produits`, `notation`, `date_creation`, `messages`) VALUES
(1, 1, 1, 5, '2025-02-11 10:56:51', 'Super produit, je le recommande vivement. Très rapide et performant!'),
(2, 2, 2, 4, '2025-02-11 10:56:51', 'Bon produit, mais un peu trop cher pour ses caractéristiques.'),
(3, 3, 3, 5, '2025-02-11 10:56:51', 'Excellente qualité, vraiment satisfait de cet achat.'),
(4, 4, 4, 3, '2025-02-11 10:56:51', 'Produit moyen. Fonctionne bien mais un peu déçu par l\'autonomie de la batterie.'),
(5, 5, 5, 4, '2025-02-11 10:56:51', 'Bon produit, léger et pratique pour le quotidien.'),
(6, 6, 6, 5, '2025-02-11 10:56:51', 'Parfait pour les tâches bureautiques et le divertissement.'),
(7, 7, 7, 4, '2025-02-11 10:56:51', 'Produit de bonne qualité, mais il y a quelques problèmes de compatibilité.'),
(8, 8, 8, 3, '2025-02-11 10:56:51', 'Bien, mais l\'écran pourrait être de meilleure qualité.'),
(9, 9, 9, 5, '2025-02-11 10:56:51', 'Très bon téléphone, très fluide et l\'appareil photo est top !'),
(10, 10, 10, 2, '2025-02-11 10:56:51', 'Décevant, il y a des bugs récurrents et la performance n\'est pas au niveau.');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `nom`, `email`, `message`) VALUES
(1, 'Jean Dupont', 'jean.dupont@example.com', 'Je souhaite avoir plus d\'informations sur le produit XYZ.'),
(2, 'Marie Durand', 'marie.durand@example.com', 'Pouvez-vous me donner les détails sur les délais de livraison ?'),
(3, 'Pierre Martin', 'pierre.martin@example.com', 'J\'ai une question concernant la garantie des produits.'),
(4, 'Sophie Bernard', 'sophie.bernard@example.com', 'Est-ce que le produit est disponible en stock ?'),
(5, 'Luc Robert', 'luc.robert@example.com', 'J\'ai rencontré un problème avec ma commande, comment puis-je le résoudre ?'),
(6, 'Claire Lefevre', 'claire.lefevre@example.com', 'Merci pour votre service, tout s\'est bien passé.'),
(7, 'Marc Lefevre', 'marc.lefevre@example.com', 'Pouvez-vous m\'aider avec le suivi de ma commande ?'),
(8, 'Julie Moreau', 'julie.moreau@example.com', 'Je voudrais connaître les options de paiement disponibles.'),
(9, 'Antoine Petit', 'antoine.petit@example.com', 'Le produit que j\'ai acheté est endommagé, que faire ?'),
(10, 'Nathalie Dubois', 'nathalie.dubois@example.com', 'Je souhaite annuler ma commande, merci de me dire comment procéder.');

-- --------------------------------------------------------

--
-- Structure de la table `details_panier`
--

CREATE TABLE `details_panier` (
  `id_details_panier` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_produits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `details_panier`
--

INSERT INTO `details_panier` (`id_details_panier`, `quantite`, `id_users`, `id_produits`) VALUES
(1, 2, 1, 1),
(2, 1, 2, 2),
(3, 3, 3, 3),
(4, 2, 4, 4),
(5, 5, 5, 5),
(6, 1, 6, 6),
(7, 4, 7, 7),
(8, 3, 8, 8),
(9, 2, 9, 9),
(10, 6, 10, 10);

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE `marques` (
  `id_marque` int(11) NOT NULL,
  `nom_marque` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `marques`
--

INSERT INTO `marques` (`id_marque`, `nom_marque`) VALUES
(1, 'Asus'),
(2, 'Dell'),
(3, 'HP'),
(4, 'Apple'),
(5, 'Lenovo'),
(6, 'Xiaomi'),
(7, 'Samsung'),
(8, 'Microsoft'),
(9, 'Huawei'),
(10, 'Sony');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produits` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `id_marques` int(11) NOT NULL,
  `id_type_produits` int(11) NOT NULL,
  `nombre_ventes` int(11) DEFAULT 0,
  `description` text NOT NULL,
  `images` varchar(255) NOT NULL DEFAULT '""',
  `promos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produits`, `nom`, `prix`, `id_marques`, `id_type_produits`, `nombre_ventes`, `description`, `images`, `promos`) VALUES
(1, 'Ordinateur Portable Asus ROG Strix', 1500.00, 1, 1, 100, 'Ordinateur portable gaming haut de gamme avec une puissance de traitement élevée.', 'ordinateurPortableAsusRogStrix.png', 20),
(2, 'Ordinateur Portable Asus Zenbook', 999.99, 1, 1, 120, 'Ordinateur ultra-léger et performant pour les professionnels et étudiants.', 'ordinateurPortableAsusZenbook.png', 15),
(3, 'Ordinateur Portable Dell Latitude 5580', 850.50, 2, 1, 80, 'Ordinateur portable fiable et robuste pour les entreprises.', 'ordinateurPortableDellLatitude5580.png', 10),
(4, 'Ordinateur Portable Dell XPS', 1200.00, 2, 1, 200, 'Ordinateur de luxe avec un écran ultra net et une performance exceptionnelle.', 'ordinateurPortableDellXps.png', 20),
(5, 'Ordinateur Portable HP', 749.99, 3, 1, 50, 'Ordinateur portable fiable pour un usage quotidien.', 'ordinateurPortableHp.png', 0),
(6, 'Tablette Android', 299.99, 6, 3, 150, 'Tablette Android polyvalente avec écran haute résolution.', 'TabletteAndroid.png', 0),
(7, 'Tablette Asus Memopad 7', 129.99, 1, 3, 80, 'Tablette compacte et pratique avec une grande autonomie.', 'TabletteAsusMemopad7.png', 15),
(8, 'Tablette iPad 3', 499.99, 4, 3, 200, 'Tablette iPad avec un écran rétina et une interface fluide.', 'TabletteIpad3.png', 0),
(9, 'iPhone 11 Gris', 799.99, 4, 2, 300, 'iPhone 11 avec un appareil photo de qualité et une performance élevée.', 'iphone11gris.png', 10),
(10, 'iPhone 14 Pro Max', 1299.99, 4, 2, 250, 'iPhone 14 Pro Max avec écran OLED, appareil photo amélioré et grande autonomie.', 'iphone14-pro-max.png', 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_produits`
--

CREATE TABLE `type_produits` (
  `id_type_produits` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_produits`
--

INSERT INTO `type_produits` (`id_type_produits`, `nom`) VALUES
(1, 'Ordinateur'),
(2, 'Smartphone'),
(3, 'Tablette');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `telephone` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `email`, `mot_de_passe`, `nom`, `prenom`, `telephone`, `adresse`, `code_postal`, `ville`, `identifiant`, `admin`) VALUES
(1, 'johndoe@example.com', 'password123', 'Doe', 'John', '0123456789', '123 Rue de Paris', '75001', 'Paris', 'johndoe', 0),
(2, 'janedoe@example.com', 'password456', 'Doe', 'Jane', '0123456790', '456 Rue de Lyon', '69002', 'Lyon', 'janedoe', 0),
(3, 'paulsmith@example.com', 'password789', 'Smith', 'Paul', '0123456791', '789 Rue de Marseille', '13003', 'Marseille', 'paulsmith', 1),
(4, 'maryjohnson@example.com', 'password101', 'Johnson', 'Mary', '0123456792', '101 Rue de Toulouse', '31000', 'Toulouse', 'maryjohnson', 0),
(5, 'michaelscott@example.com', 'password102', 'Scott', 'Michael', '0123456793', '102 Rue de Bordeaux', '33000', 'Bordeaux', 'michaelscott', 1),
(6, 'emilybrown@example.com', 'password103', 'Brown', 'Emily', '0123456794', '103 Rue de Lille', '59000', 'Lille', 'emilybrown', 0),
(7, 'davidwilson@example.com', 'password104', 'Wilson', 'David', '0123456795', '104 Rue de Nice', '06000', 'Nice', 'davidwilson', 0),
(8, 'sarahmiller@example.com', 'password105', 'Miller', 'Sarah', '0123456796', '105 Rue de Nantes', '44000', 'Nantes', 'sarahmiller', 0),
(9, 'robertharris@example.com', 'password106', 'Harris', 'Robert', '0123456797', '106 Rue de Rennes', '35000', 'Rennes', 'robertharris', 1),
(10, 'lindawilson@example.com', 'password107', 'Wilson', 'Linda', '0123456798', '107 Rue de Strasbourg', '67000', 'Strasbourg', 'lindawilson', 0),
(11, 'alexandrefourquin@hotmail.fr', '$2y$10$68D.DJeY8ee3I1CYKlwVTeSvIq.nIhAlOreThrqg8WG9t2tULqpaW', 'alex', 'alex', '0677932655', '366 rue de vaugirard', '75015', 'paris', 'alex75015', 0),
(12, 'alexandre@hotmail.fr', '$2y$10$kvTnVXt7hVZ8tqmxnIja7e.7ut931FBMxgsuLcbU1vtvLvrBnJN1S', 'alexandre', 'batte', '', '', '', '', '', 0),
(13, 'alex@hotmail.fr', '$2y$10$yvidDmZfidbgn4UoDUw7AefAhOcWp/5.tlxTzCD703iVb8Qmx8bka', 'alex', 'alex', '', '', '', '', '', 0),
(14, 'alexi@hotmail.fr', '$2y$10$NbJ6N4KGrcm334pjk4iBqOpEPgzVEw9BHvkx6zQoVf5eutxp9FUAS', 'alex', 'alex', '', '', '', '', '', 0),
(15, 'alexou@hotmail.fr', '$2y$10$w3/afhoiYBMgcx7XR569Le7tH8QqSExsVzPqYnGfFWXK5FDQtNP/K', 'alex', 'alexandri', '', '', '', '', '', 0),
(16, 'abcd@hotmail.fr', '$2y$10$61Jmil3xAz6eLX158vAPBuDdVr8oMoNp2WyJi3d1WW1Opc2FfhUzi', 'alexou', 'ale', '', '', '', '', '', 0),
(17, 'al@hotmail.fr', '$2y$10$A5Mnj2QOAENmNvJOT3bgv.cCYQMWfHNYOvGHqFT3e.zDONXEroPM6', 'hehe', 'alexddd', '', '', '', '', '', 0),
(18, 'ababa@hotmail.fr', '$2y$10$UF1OHyUWjIrfNQhPSx7En.eAuNSYjmRy6WeezOFhLR8GK7g8yNs0a', 'sssz', 'sss', '', '', '', '', '', 0),
(19, 'b@hotmail.fr', '$2y$10$eVJLikSO9lQV11les7ZtuOj6TVdzZmK0GpVAqlUzEPx3AQEUSOehe', 'a', 'b', '', '', '', '', '', 0),
(20, 'c@hotmail.fr', '$2y$10$jYio6jG0d01EqN6G9lxcz.xgxqjPzw4eTqOpNRuV1pyl6KN5mnqmm', 'martin', 'jean', '', '', '', '', '', 0),
(21, 'p@hotmail.fr', '$2y$10$WW8aG801UMHLCLEN7PNix.GVTueeAPZRRN7ywo79.4M9Nv8AwvMky', 'le grand', 'paul', '', '', '', '', '', 0),
(22, 'd@hotmail.fr', '$2y$10$CrJhcdYoB/i5gcf3OmXMqu5yfAFRHo8QNmfHqFbBI6TE88kJvB./y', 'trump', 'donald', '', '', '', '', '', 0),
(23, 'x@hotmail.fr', '$2y$10$P4WikgFpc7ibQleXv.TBc.ani9MZE6HkvrKFuXDbh3NrbFTelU71O', 'a', 'b', '', '', '', '', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaires`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_produits` (`id_produits`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `details_panier`
--
ALTER TABLE `details_panier`
  ADD PRIMARY KEY (`id_details_panier`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_produits` (`id_produits`);

--
-- Index pour la table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id_marque`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produits`),
  ADD KEY `id_type_produits` (`id_type_produits`),
  ADD KEY `id_marques` (`id_marques`);

--
-- Index pour la table `type_produits`
--
ALTER TABLE `type_produits`
  ADD PRIMARY KEY (`id_type_produits`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaires` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `details_panier`
--
ALTER TABLE `details_panier`
  MODIFY `id_details_panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `marques`
--
ALTER TABLE `marques`
  MODIFY `id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produits` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `type_produits`
--
ALTER TABLE `type_produits`
  MODIFY `id_type_produits` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_produits`) REFERENCES `produits` (`id_produits`);

--
-- Contraintes pour la table `details_panier`
--
ALTER TABLE `details_panier`
  ADD CONSTRAINT `details_panier_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `details_panier_ibfk_2` FOREIGN KEY (`id_produits`) REFERENCES `produits` (`id_produits`),
  ADD CONSTRAINT `details_panier_ibfk_3` FOREIGN KEY (`id_produits`) REFERENCES `produits` (`id_produits`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_marques`) REFERENCES `marques` (`id_marque`),
  ADD CONSTRAINT `produits_ibfk_2` FOREIGN KEY (`id_type_produits`) REFERENCES `type_produits` (`id_type_produits`),
  ADD CONSTRAINT `produits_ibfk_3` FOREIGN KEY (`id_marques`) REFERENCES `marques` (`id_marque`),
  ADD CONSTRAINT `produits_ibfk_4` FOREIGN KEY (`id_marques`) REFERENCES `marques` (`id_marque`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
