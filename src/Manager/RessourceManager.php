<?php

namespace Manager;

use DateTime;
use Entity\CategorieRessource;
use Entity\TypeRessource;
use Entity\User;
use Entity\Ressource;
use PDO;
use Security\EncoderInterface;

/**
 * Class UserManager
 *
 * Gestionnaire des utilisateurs : service (objet) responsable
 * d'ÉCRIRE dans la base de données (par opposition à la
 * classe UserRepository qui est responsable de LIRE).
 *
 * Note: les méthodes de cet classe ne renvoient aucune valeur
 * car en cas d'erreur elles "lèveraient une exception".
 * @see https://www.php.net/manual/fr/language.exceptions.php
 * @see https://www.php.net/manual/fr/pdo.connections.php
 */
class RessourceManager
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

    public function insert(Ressource $ressource): void
    {
        // Prépare une requête d'insertion d'une ressource
        $insert = $this->connection->prepare(
            'INSERT INTO ressource(titre, contenu, id_createur, id_categorie, id_type, date_modification) '.
            'VALUES (:titre, :contenu, :idCreateur, :idCategorie, :idType, current_timestamp);'
        );
        

        // Execute la requête d'insertion
        $insert->execute([
            'titre'             => $ressource->getTitre(),
            'contenu'           => $ressource->getContenu(),
            'idCreateur'        => $ressource->getCreateur()->getId(),
            'idCategorie'       => array_search($ressource->getCategorie(), CategorieRessource::categories)+1,
            'idType'            => array_search($ressource->getType(), TypeRessource::types)+1,
        ]);

        // Mettre à jour l'identifiant de la ressource
        $ressource->setId($this->connection->lastInsertId());
    }

    /**
     * Mets à jour une ressource dans la base de données.
     *
     * @param Ressource $ressource L'instance de la classe Ressource
     *                   à modifier dans la base de données.
     */
    public function update(Ressource $ressource): void
    {
        // Si l'identifiant de l'utilisateur n'est pas un nombre entier positif
        if (0 >= $ressource->getId()) {
            // On ne peut pas mettre à jour cet utilisateur
            throw new \Exception("Ressource introuvable");
        }

        // Les champs que l'on souhaite mettre à jour
        // (à gauche, le nom de la colonne de la base de données)
        $couples = [
            'titre=' . $this->connection->quote($ressource->getTitre()),
            'contenu=' . $this->connection->quote($ressource->getContenu()),
            'id_categorie=' . $this->connection->quote(array_search($ressource->getCategorie(), CategorieRessource::categories)+1),
            'id_type=' . $this->connection->quote(array_search($ressource->getType(), TypeRessource::types)+1),
            'date_modification=' . 'current_timestamp',
        ];
        
        // Execute la requête de mise à jour
        $this->connection->query(
            'UPDATE ressource SET ' . implode(',', $couples) .
            ' WHERE id=' . $ressource->getId() . ' LIMIT 1'
        );
    }

    /**
     * Supprime une ressource de la base de données.
     *
     * @param Ressource $ressource L'instance de la classe Ressource
     *                  à supprimer de la base de données.
     */
    public function delete(Ressource $ressource): void
    {
        // Si l'identifiant de l'utilisateur n'est pas un nombre entier positif
        if (0 >= $ressource->getId()) {
            // On ne peut pas supprimer cet utilisateur
            throw new \Exception("Ressource introuvable");
        }

        // Prépare la requête de suppression
        $delete = $this->connection->prepare(
            'DELETE FROM ressource WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de suppression
        $delete->execute([
            'param_id' => $ressource->getId(),
        ]);
    }
}
