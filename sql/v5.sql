ALTER TABLE `user`
  ADD `nom` varchar(255) NOT NULL;

ALTER TABLE `user`
  ADD `prenom` varchar(255) NOT NULL;

/* Utilisateur par défaut :
   Email        : admin@example.org
   Mot de passe : admin
 */
INSERT INTO `user` (`id`, `email`, `password`, `droit`, `nom`, `prenom`) VALUES
(13, 'admin@example.org', '21232f297a57a5a743894a0e4a801fc3', 3, 'admin', 'admin');