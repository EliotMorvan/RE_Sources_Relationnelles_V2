CREATE TABLE `ressource` (
  `id` int NOT NULL,
  `titre` varchar(255),
  `contenu` LONGTEXT,
  `id_createur` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ressource`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ressource`
  ADD FOREIGN KEY (id_createur) REFERENCES user(id);
  
ALTER TABLE `ressource`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/* Utilisateur par défaut :
   titre        : titre
   contenu	    : contenu
   id_createur  : 13
 */
INSERT INTO `ressource` (`id`, `titre`, `contenu`, `id_createur`) VALUES
(1, 'titre', 'contenu', 13);
