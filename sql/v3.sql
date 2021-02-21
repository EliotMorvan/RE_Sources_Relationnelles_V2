CREATE TABLE `type_ressource` (
  `id` int NOT NULL,
  `nom` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `type_ressource`
  ADD PRIMARY KEY (`id`);

-- Une ressource possède un type de ressource

ALTER TABLE `ressource`
  ADD id_type int;

ALTER TABLE `ressource`
  ADD FOREIGN KEY (id_type) REFERENCES type_ressource(id);

-- Ajout des catégories imposées

INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(1, 'Activité / Jeu à réaliser');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(2, 'Article');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(3, 'Carte défi');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(4, 'Cours au format PDF');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(5, 'Exercice / Atelier');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(6, 'Fiche de lecture');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(7, 'Jeu en ligne');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(8, 'Vidéo');
INSERT INTO `type_ressource` (`id`, `nom`) VALUES
(9, 'Discussion');
