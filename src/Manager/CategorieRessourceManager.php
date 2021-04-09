<?php

namespace Manager;

use Entity\CategorieRessource;
use PDO;
use Security\EncoderInterface;

/**
 * Class CategorieRessourceManager
 *
 * Note: les méthodes de cet classe ne renvoient aucune valeur
 * car en cas d'erreur elles "lèveraient une exception".
 * @see https://www.php.net/manual/fr/language.exceptions.php
 * @see https://www.php.net/manual/fr/pdo.connections.php
 */
class CategorieRessourceManager
{
    /** PDO */
    private $connection;

    /** @var EncoderInterface */
    private $encoder;

    /**
     * Constructor.
     *
     * @param PDO              $connection La connection à la base de données
     * @param EncoderInterface $encoder    Encodeur de mot de passe
     */
    public function __construct(PDO $connection, EncoderInterface $encoder)
    {
        $this->connection = $connection;
        $this->encoder = $encoder;
    }

    public function insert(CategorieRessource $categorie): void
    {
        $insert = $this->connection->prepare(
            'INSERT INTO categorie_ressource(nom) '.
            'VALUES (:nom);'
        );

        $insert->execute([
            'nom'      => $categorie->getNom(),
        ]);

        $categorie->setId($this->connection->lastInsertId());
    }

    public function update(CategorieRessource $categorie): void
    {
        if (0 >= $categorie->getId()) {
            throw new \Exception("Category must have an id");
        }

        $couples = [
            'nom=' . $this->connection->quote($categorie->getNom()),
        ];

        $this->connection->query(
            'UPDATE categorie_ressource SET ' . implode(',', $couples) .
            ' WHERE id=' . $categorie->getId() . ' LIMIT 1'
        );
    }

    public function remove(CategorieRessource $categorie): void
    {
        if (0 >= $categorie->getId()) {
            throw new \Exception("Category must have an id");
        }

        $delete = $this->connection->prepare(
            'DELETE FROM categorie_ressource WHERE id=:param_id LIMIT 1'
        );

        $delete->execute([
            'param_id' => $categorie->getId(),
        ]);
    }
}
