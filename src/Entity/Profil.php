<?php

namespace Entity;

class Profil {

    private $user;

    private $ressourcesFavoris;

    private $ressourcesCreateur;

    private $categories;

    private $types;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getRessourcesFavoris()
    {
        return $this->ressourcesFavoris;
    }

    public function setRessourcesFavoris(Array $ressourcesFavoris)
    {
        $this->ressourcesFavoris = $ressourcesFavoris;

        return $this;
    }

    public function getRessourcesCreateur()
    {
        return $this->ressourcesCreateur;
    }

    public function setRessourcesCreateur(Array $ressourcesCreateur)
    {
        $this->ressourcesCreateur = $ressourcesCreateur;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories(Array $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setTypes(Array $types)
    {
        $this->types = $types;

        return $this;
    }
}
