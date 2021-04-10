<?php

namespace Repository;

use Entity\CategorieRessource;
use Entity\Ressource;
use PDO;

/**
 * Class RessourceRepository
 *
 * Dépôt des ressources : service (objet) responsable de LIRE
 * dans la base de données (par opposition à la classe
 * RessourceManager qui est responsable d'ÉCRIRE).
 */
class CategorieRessourceRepository
{
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, nom, actif FROM categorie_ressource WHERE actif = TRUE'
        );

        // Liste des ressources à renvoyer
        $categoriesRessources = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $categoriesRessources[] = $this->buildCategorieRessource($data);
        }

        // Renvoi la liste des utilisateurs
        return $categoriesRessources;
    }

    public function findAllAdmin(): array
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, nom, actif FROM categorie_ressource'
        );

        // Liste des ressources à renvoyer
        $categoriesRessources = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $categoriesRessources[] = $this->buildCategorieRessource($data);
        }

        // Renvoi la liste des utilisateurs
        return $categoriesRessources;
    }

    /**
     * Renvoi la ressource possédant l'ID passé en paramètre.
     *
     * @return Ressource
     */
    public function findOneById(int $id): ?CategorieRessource
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, nom, actif FROM categorie_ressource ' .
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        // Renvoi la liste des ressources
        return $this->buildCategorieRessource($data);
    }

    public function getCategoriesUsedForCreateur(int $idCreateur): ?Array
    {
        $select = $this->connection->query(
            'SELECT categorie_ressource.id, categorie_ressource.nom, categorie_ressource.actif FROM `categorie_ressource` JOIN ressource on categorie_ressource.id = ressource.id_categorie JOIN user on ressource.id_createur = user.id ' .
            'WHERE user.id = ' . $idCreateur . ';'
        ); 

        // Liste des ressources à renvoyer
        $categoriesRessources = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $categoriesRessources[] = $this->buildCategorieRessource($data);
        }

        // Renvoi la liste des utilisateurs
        return $categoriesRessources;
    }

    private function buildCategorieRessource(array $data): CategorieRessource
    {
        $categorie = new CategorieRessource();
        $categorie->setId($data['id']);
        $categorie->setNom($data['nom']);
        $categorie->setActif($data['actif']);

        return $categorie;
    }
}
