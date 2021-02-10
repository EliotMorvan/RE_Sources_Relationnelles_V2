<?php

namespace Repository;

use Entity\User;
use Entity\Ressource;
use PDO;

/**
 * Class UserRepository
 *
 * Dépôt des utilisateurs : service (objet) responsable de LIRE
 * dans la base de données (par opposition à la classe
 * UserManager qui est responsable d'ÉCRIRE).
 */
class RessourceRepository
{
    /** PDO */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection La connection à la base de données.
     */
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Renvoi tous les utilisateurs.
     *
     * @return Ressource[] Un tableau contenant des instances de la classe User
     */
    public function findAll(): array
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, titre, contenu, id_createur FROM ressource'
        );

        // Liste des ressources à renvoyer
        $ressources = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $ressources[] = $this->buildRessource($data);
        }

        // Renvoi la liste des utilisateurs
        return $ressources;
    }

    /**
     * Builds the user from the given data.
     *
     * @param array $data
     *
     * @return Ressource
     */
    private function buildRessource(array $data): Ressource
    {
        $ressource = new Ressource();
        $ressource->setId($data['id']);
        $ressource->setTitre($data['titre']);
        $ressource->setContenu($data['contenu']);
        $ressource->setIdCreateur($data['id_createur']);

        return $ressource;
    }
}
