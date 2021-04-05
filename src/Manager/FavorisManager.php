<?php

namespace Manager;

use Entity\Ressource;
use Entity\User;
use Entity\favoris;
use PDO;

class FavorisManager
{

 /** PDO */
 private $connection;
  /** @var EncoderInterface */
  private $encoder;

  public function create (favoris $favoris):void
  {
      //prépare la création d'un favoris dans la base de données
      $insert = $this->connection->prepare(
        'INSERT INTO favoris(id_createur, id_ressource) '.
        'VALUES (:idCreateur, :idressources);'
    );
    // Execute la requete de création
    $insert->execute([
      'id_createur'       =>$favoris->getCreateur()->getid(),
      'id_ressource'      =>$favoris->getRessouce()->getid()
    ]);
    // Mettre à jour l'identifiant du favoris
    $favoris->setId($this->connection->lastInsertId());
}
}