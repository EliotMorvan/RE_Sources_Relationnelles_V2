<?php

namespace Entity;

/**
 * Class User
 *
 * Entité utilisateur : Objet représentant
 * un utilisateur dans la base de donnée.
 */
class User {
    /**
     * L'identifiant de l'utilisateur
     * @var int
     */
    private $id;

    /**
     * Email de l'utilisateur
     * @var string
     */
    private $email;

    /**
     * Mot de passe (crypté) de l'utilisateur
     * @var string
     */
    private $password;

    /**
     * Mot de passe (en clair) de l'utilisateur.
     * Utilisé dans les formulaires de création et de modification d'un utilisateur.
     * Ne sera pas enregistré dans la base de données.
     * @var string
     */
    private $plainPassword;

    /**
     * Droit de l'utilisateur.
     * 0 - Utilisateur connecté
     * 1 - Modérateur
     * 2 - Administrateur
     * 3 - Super-Amdinistrateur
     * @var int
     */
    private $droit;

    /**
     * Prenom de l'utilisateur
     * @var string
     */
    private $prenom;

    /**
     * Nom de l'utilisateur
     * @var string
     */
    private $nom;


    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getDroit()
    {
        return $this->droit;
    }

    public function setDroit(int $droit)
    {
        $this->droit = $droit;

        return $this;
    }

    public function isModerateur()
    {
        if ($this->droit === 1 || 2 || 3) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdministrateur()
    {
        if ($this->droit === 2 || 3) {
            return true;
        } else {
            return false;
        }
    }

    public function isSuperAdministrateur()
    {
        if ($this->droit === 3) {
            return true;
        } else {
            return false;
        }
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }
}
