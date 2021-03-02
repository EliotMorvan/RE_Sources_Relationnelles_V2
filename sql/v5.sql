ALTER TABLE `user`
  ADD `nom` varchar(255) NOT NULL;

ALTER TABLE `user`
  ADD `prenom` varchar(255) NOT NULL;

/* Utilisateur par défaut :
   Email        : admin@example.org
   Mot de passe : admin
 */
INSERT INTO `user` (`id`, `email`, `password`, `droit`, `nom`, `prenom`) VALUES
(13, 'admin@example.org', 'admin', 3, 'admin', 'admin');