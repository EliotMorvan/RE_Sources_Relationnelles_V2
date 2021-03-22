<?php

namespace Repository;

use DateTime;
use Entity\Commentaire;
use Entity\Ressource;
use Entity\User;
use PDO;

class CommentaireRepository
{
    private $connection;

    /** 
     * @var UserRespository 
    */
    private $userRespository;

    public function __construct(PDO $connection, UserRepository $userRespository) {
        $this->connection = $connection;
        $this->userRespository = $userRespository;
    }

    public function findAllForIdRessource(int $id): array
    {
        // Récupérer la liste des commentaires de la ressource
        $select = $this->connection->query(
            'SELECT id, id_ressource, contenu, id_user, date_modification FROM commentaire WHERE id_ressource=' . $id 
                . ' ORDER BY date_modification;'
        );

        // Liste des ressources à renvoyer
        $commentaires = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $commentaires[] = $this->buildCommentaire($data);
        }

        // Renvoi la liste des utilisateurs
        return $commentaires;
    }

    /**
     * Renvoi la ressource possédant l'ID passé en paramètre.
     *
     * @return Commentaire
     */
    public function findOneById(int $id): ?Commentaire
    {
        // Récupérer la liste des ressources
        $select = $this->connection->query(
            'SELECT id, nom FROM categorie_ressource ' .
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        // Renvoi la liste des ressources
        return $this->buildCommentaire($data);
    }

    private function buildCommentaire(array $data): Commentaire
    {
        $commentaire = new Commentaire();
        $commentaire->setId($data['id']);
        
        // Récupération du créateur de la ressource
        $createur = $this->userRespository->findOneById($data['id_user']);
        $commentaire->setCreateur($createur);

        // Gestion de la date de modif
        $dateModification = new DateTime($data['date_modification']);
        $commentaire->setDateModfication($dateModification);

        $commentaire->setContenu($data['contenu']);
        
        return $commentaire;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}
