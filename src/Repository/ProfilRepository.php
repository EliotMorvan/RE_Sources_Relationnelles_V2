<?php

namespace Repository;

use Entity\Profil;
use Entity\User;
use PDO;

/**
 * Class UserRepository
 *
 * Dépôt des utilisateurs : service (objet) responsable de LIRE
 * dans la base de données (par opposition à la classe
 * UserManager qui est responsable d'ÉCRIRE).
 */
class ProfilRepository
{
    /** PDO */
    private $connection;

    private $ressourceRepository;

    private $favorisRepository;

    private $categorieRepository;

    /**
     * Constructor.
     *
     * @param PDO $connection La connection à la base de données.
     */
    public function __construct(PDO $connection, RessourceRepository $ressourceRepository, FavorisRepository $favorisRepository, CategorieRessourceRepository $categorieRessourceRepository) {
        $this->connection = $connection;
        $this->ressourceRepository = $ressourceRepository;
        $this->favorisRepository = $favorisRepository;
        $this->categorieRessourceRepository = $categorieRessourceRepository;
    }

    public function findProfilById(User $user): Profil 
    {
        $profil = new Profil();
        $profil->setUser($user);

        $ressourcesFavoris = $this->favorisRepository->findAll();
        $profil->setRessourcesFavoris($ressourcesFavoris);

        $ressourcesCreateur = $this->ressourceRepository->findAllForCreateur($user->getId());
        $profil->setRessourcesCreateur($ressourcesCreateur);

        $categories = $this->categorieRessourceRepository->getCategoriesUsedForCreateur($user->getId());
        $profil->setCategories(array_unique($categories, SORT_REGULAR));

        $types = array();
        foreach ($ressourcesCreateur as $ressource) {
            array_push($types, $ressource->gettype());
        }
        $types = array_unique($types);
        $profil->setTypes(array_unique($types, SORT_REGULAR));

        return $profil;
    }
}
