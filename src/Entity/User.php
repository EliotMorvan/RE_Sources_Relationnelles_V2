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
}
