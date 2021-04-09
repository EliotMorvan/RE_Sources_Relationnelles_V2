-- Création et instanciation des catégories de ressources

CREATE TABLE `categorie_ressource` (
  `id` int NOT NULL,
  `nom` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `categorie_ressource`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categorie_ressource`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- Une ressource possède une catégorie de ressource

ALTER TABLE `ressource`
  ADD id_categorie int;

ALTER TABLE `ressource`
  ADD FOREIGN KEY (id_categorie) REFERENCES categorie_ressource(id);

-- Ajout des catégories imposées

INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(1, 'Communication');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(2, 'Culture');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(3, 'Développement personnel');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(4, 'Intelligence émotionnelle');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(5, 'Loisirs');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(6, 'Monde professionnels');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(7, 'Parentalité');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(8, 'Qualité de vie');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(9, 'Recherche de sens');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(10, 'Santé physique');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(11, 'Santé psychique');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(12, 'Spiritualité');
INSERT INTO `categorie_ressource` (`id`, `nom`) VALUES
(13, 'Vie affective');
