CREATE TABLE `favoris` (
  `id` int NOT NULL,
  `id_user`int NOT NULL,
  `id_ressource` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `favoris`
  ADD FOREIGN KEY (id_user) REFERENCES user(id);

ALTER TABLE `favoris`
  ADD FOREIGN KEY (id_ressource) REFERENCES ressource(id);
  
ALTER TABLE `favoris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;