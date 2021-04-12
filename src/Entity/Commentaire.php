<?php 

namespace Entity;

use DateTime;

/** objet représentant une ressources favorites pour un utilisateur */

class Commentaire {

        private $id;

        private $createur;

        private $ressource;

        private $contenu;
        
        private $dateModification;


        public function getId()
        {
                return $this->id;
        }

        public function setId(int $id)
        {
                $this->id = $id;
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

        public function getRessource()
        {
                return $this->ressource;
        }

        public function setRessource(Ressource $ressource)
        {
                $this->ressource = $ressource;
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
