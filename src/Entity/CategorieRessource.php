<?php 

namespace Entity;

class CategorieRessource {
/**
     * L'identifiant de la ressource
     * @var int
     */
    private $id;

    /**
     * Le titre de la ressource
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
?>