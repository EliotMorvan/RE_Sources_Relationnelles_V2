<?php

namespace Manager;

use Entity\User;
use Entity\Ressource;
use PDO;
use Security\EncoderInterface;

/**
 * Class RessourceManager
 *
 * Gestionnaire des ressource : service (objet) responsable
 * d'ÉCRIRE dans la base de données (par opposition à la
 * classe RessourceRepository qui est responsable de LIRE).
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

/**
     * Ajoute une ressource dans la base données.
     *
     * @param Ressourcer $ressource L'instance de la classe Ressource
     *                   à enregistrer dans la base de données.
     */
    public function insert(Ressource $ressource): void
    {
        // Prépare une requête d'insertion d'une ressource
        $insert = $this->connection->prepare(
            'INSERT INTO ressource(titre, contenu, id_user) '.
            'VALUES (:titre, :contenu,:id_user);'
        );

        // Execute la requête d'insertion
        $insert->execute([
            'titre'    => $ressource->getTitre(),
            'contenu' => $ressource->getContenu(),
            'id_user' => $ressource->getIDCreateur(),
        ]);

        // Mettre à jour l'identifiant de l'utilisateur
        $ressource->setId($this->connection->lastInsertId());
     
    }
}