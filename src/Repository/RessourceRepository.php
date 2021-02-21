<?php

namespace Repository;

use Entity\CategorieRessource;
use Entity\Ressource;
use Entity\TypeRessource;
use Repository\UserRepository;
use PDO;

/**
 * Class RessourceRepository
 *
 * Dépôt des ressources : service (objet) responsable de LIRE
 * dans la base de données (par opposition à la classe
 * RessourceManager qui est responsable d'ÉCRIRE).
 */
class RessourceRepository
{
    /** PDO */
    private $connection;

    /** 
     * @var UserRespository 
    */
    private $userRespository;

    /**
     * Constructor.
     *
     * @param PDO $connection La connection à la base de données.
     */
    public function __construct(PDO $connection, UserRepository $userRespository) {
        $this->connection = $connection;
        $this->userRespository = $userRespository;
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
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type FROM ressource'
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
     * Renvoi la ressource possédant l'ID passé en paramètre.
     *
     * @return Ressource
     */
    public function findOneById(int $id): ?Ressource
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type FROM ressource ' .
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        // Renvoi la liste des ressources
        return $this->buildRessource($data);
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

        // Récupération du créateur de la ressource
        $createur = $this->userRespository->findOneById($data['id_createur']);
        $ressource->setCreateur($createur);

        // Récupération de la catégorie de ressource
        $ressource->setCategorie(CategorieRessource::categories[$data['id_categorie']-1]);

        // Récupération du type de la ressource
        $ressource->setType(TypeRessource::types[$data['id_type']-1]);
        return $ressource;
    }
}
