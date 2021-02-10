<?php

namespace Entity;

/**
 * Class User
 *
 * Entité utilisateur : Objet représentant
 * un utilisateur dans la base de donnée.
 */
class Ressource {
    /**
     * L'identifiant de l'utilisateur
     * @var int
     */
    private $id;

    /**
     * Email de l'utilisateur
     * @var string
     */
    private $titre;

    /**
     * Mot de passe (crypté) de l'utilisateur
     * @var string
     */
    private $contenu;

    /**
     * Mot de passe (en clair) de l'utilisateur.
     * Utilisé dans les formulaires de création et de modification d'un utilisateur.
     * Ne sera pas enregistré dans la base de données.
     * @var int
     */
    private $idCreateur;


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

    public function getIdCreateur()
    {
        return $this->idCreateur;
    }

    public function setIdCreateur(int $idCreateur)
    {
        $this->idCreateur = $idCreateur;

        return $this;
    }
}
