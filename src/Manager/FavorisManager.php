<?php

namespace Manager;

use Entity\Ressource;
use Entity\User;
use Entity\favoris;
use PDO;
use Security\EncoderInterface;

class FavorisManager
{

  /** PDO */
  private $connection;

  /** @var EncoderInterface */
  private $encoder;

  public function __construct(PDO $connection, EncoderInterface $encoder)
  {
      $this->connection = $connection;
      $this->encoder = $encoder;
  }

  public function create(favoris $favoris): void
  {
    //prépare la création d'un favoris dans la base de données
    $insert = $this->connection->prepare(
      'INSERT INTO favoris(id_user, id_ressource) '.
      'VALUES (:idCreateur, :idRessource);'
    );

    // Execute la requete de création
    $insert->execute([
      'idCreateur'       =>$favoris->getCreateur()->getId(),
      'idRessource'      =>$favoris->getRessouce()->getId(),
    ]);

    // Mettre à jour l'identifiant du favoris
    $favoris->setId($this->connection->lastInsertId());
  }

  public function delete(favoris $favoris): void
  {
    //prépare la création d'un favoris dans la base de données
    $delete = $this->connection->prepare(
      'DELETE FROM `favoris` WHERE id_user = (:idCreateur) AND id_ressource = (:idRessource); '
    );

    // Execute la requete de création
    $delete->execute([
      'idCreateur'       =>$favoris->getCreateur()->getId(),
      'idRessource'      =>$favoris->getRessouce()->getId(),
    ]);
  }
}