CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `droit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/* Utilisateur par défaut :
   Email        : admin@example.org
   Mot de passe : admin
 */
INSERT INTO `user` (`id`, `email`, `password`, `droit`) VALUES
(13, 'admin@example.org', '21232f297a57a5a743894a0e4a801fc3', 3);
