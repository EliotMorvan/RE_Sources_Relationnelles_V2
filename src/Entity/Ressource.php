<?php

namespace Entity;

use DateTime;

/**
 * Class Ressource
 *
 * Entité Ressource : Objet représentant
 * une ressource dans la base de donnée.
 */
class Ressource {
    /**
     * L'identifiant de la ressource
     * @var int
     */
    private $id;

    /**
     * Le titre de la ressource
     * @var string
     */
    private $titre;

    /**
     * Le contenu de la ressource
     * @var string
     */
    private $contenu;

    /**
     * Le créateur de la ressource
     * Stockage en base de son ID et récupération de l'entity User
     * Lors de la construction de la ressource
     * @var User
     */
    private $createur;

    /**
     * La dernière date de modification de la ressource
     * @var DateTime
     */
    private $dateModfication;


    /**
     * La catégorie de la ressource
     * @var CategorieRessource
     */
    private $categorie;

    /**
     * Le type de la ressource
     * @var string
     */
    private $type;


    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre(string $titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreateur()
    {
        return $this->createur;
    }

    public function setCreateur(User $createur)
    {
        $this->createur = $createur;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie(CategorieRessource $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function getDateModification()
    {
        return $this->dateModfication;
    }

    public function setDateModfication(DateTime $dateModfication)
    {
        $this->dateModfication = $dateModfication;

        return $this;
    }
}
