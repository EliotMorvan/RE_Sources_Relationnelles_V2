<?php

namespace Repository;

use DateTime;
use Entity\CategorieRessource;
use Entity\Commentaire;
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
     * @var CategorieRessourceRespository 
    */
    private $categorieRessourceRespository;

    /** 
     * @var CommentaireRepository 
    */
    private $commentaireRespository;

    /** 
     * @var FavorisRepository 
    */
    private $favorisRespository;


    /**
     * Constructor.
     *
     * @param PDO $connection La connection à la base de données.
     */
    public function __construct(PDO $connection, UserRepository $userRespository, CategorieRessourceRepository $categorieRessourceRespository, CommentaireRepository $commentaireRespository, FavorisRepository $favorisRepository) {
        $this->connection = $connection;
        $this->userRespository = $userRespository;
        $this->categorieRessourceRespository = $categorieRessourceRespository;
        $this->commentaireRespository = $commentaireRespository;
        $this->favorisRespository = $favorisRepository;
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
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type, date_modification FROM ressource ORDER BY date_modification DESC'
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

    public function findAllForCategory(int $id): array
    {
        $select = $this->connection->query(
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type, date_modification FROM ressource WHERE id_categorie = ' . $id
        );

        $ressources = [];

        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $ressources[] = $this->buildRessource($data);
        }

        return $ressources;
    }

    public function findAllForType(int $id): array
    {
        $select = $this->connection->query(
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type, date_modification FROM ressource WHERE id_type = ' . $id
        );

        $ressources = [];

        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $ressources[] = $this->buildRessource($data);
        }

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
            'SELECT id, titre, contenu, id_createur, id_categorie, id_type, date_modification FROM ressource ' .
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

    public function findOneCommentaireById(int $id): ?Commentaire
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, id_user, id_ressource, contenu, date_modification FROM commentaire ' .
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        // Renvoi le commentaire
        return $this->buildCommentaire($data);
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

        //Réupération de la dernière date de modification
        $dateModification = new DateTime($data['date_modification']);
        $ressource->setDateModfication($dateModification);

        // Récupération du créateur de la ressource
        $createur = $this->userRespository->findOneById($data['id_createur']);
        $ressource->setCreateur($createur);

        // Récupération de la catégorie de ressource
        $ressource->setCategorie($this->categorieRessourceRespository->findOneById($data['id_categorie']));

        // Récupération du type de la ressource
        $ressource->setType(TypeRessource::types[$data['id_type']-1]);

        // Récupération des commentaires
        $commentaires = $this->commentaireRespository->findAllForIdRessource($data['id']);
        $ressource->setCommentaires($commentaires);

        // Récup des user favoris pour cette ressource
        $userFavoris = $this->favorisRespository->findIdRessource($ressource->getId());
        $ressource->setUserFavoris($userFavoris);

        return $ressource;
    }

    private function buildCommentaire(array $data): Commentaire
    {
        $commentaire = new Commentaire();
        $commentaire->setId($data['id']);
        $commentaire->setContenu($data['contenu']);

        //Réupération de la dernière date du commentaire
        $dateModification = new DateTime($data['date_modification']);
        $commentaire->setDateModfication($dateModification);

        // Récupération du créateur du commentaire
        $createur = $this->userRespository->findOneById($data['id_user']);
        $commentaire->setCreateur($createur);

        // Récupération de la ressource du commentaire
        $ressource = $this->findOneById($data['id_ressource']);
        $commentaire->setRessource($ressource);

        return $commentaire;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}
