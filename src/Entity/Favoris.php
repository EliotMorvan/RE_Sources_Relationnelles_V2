<?php 

namespace Entity;

/** objet représentant une ressources favorites pour un utilisateur */

class favoris {
        /**
         * L'identifiant du favoris
         * @var int
         */
        private $id;
    
         /**
         * Le créateur du favoris
         * Stockage en base de son ID et récupération de l'entity User
         * Lors de la construction du favoris
         * @var User
         */
        private $createur;

        /**la ressource favorite
         * Stockage en base de son ID et récupération de l'entity Ressources
         * @var Ressource
         */

        private $ressouce;



        /**
         * Get l'identifiant du favoris
         *
         * @return  int
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set l'identifiant du favoris
         *
         * @param  int  $id  L'identifiant du favoris
         *
         * @return  self
         */ 
        public function setId(int $id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get lors de la construction du favoris
         *
         * @return  User
         */ 
        public function getCreateur()
        {
                return $this->createur;
        }

        /**
         * Set lors de la construction du favoris
         *
         * @param  User  $createur  Lors de la construction du favoris
         *
         * @return  self
         */ 
        public function setCreateur(User $createur)
        {
                $this->createur = $createur;

                return $this;
        }

        /**
         * Get the value of ressouce
         */ 
        public function getRessouce()
        {
                return $this->ressouce;
        }

        /**
         * Set the value of ressouce
         *
         * @return  self
         */ 
        public function setRessouce($ressouce)
        {
                $this->ressouce = $ressouce;

                return $this;
        }
}
