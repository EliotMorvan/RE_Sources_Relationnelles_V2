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
