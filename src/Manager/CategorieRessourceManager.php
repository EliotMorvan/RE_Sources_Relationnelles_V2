<?php

namespace Manager;

use DateTime;
use Entity\CategorieRessource;
use Entity\TypeRessource;
use Entity\User;
use Entity\Ressource;
use PDO;
use Security\EncoderInterface;

/**
 * Class UserManager
 *
 * Gestionnaire des utilisateurs : service (objet) responsable
 * d'ÉCRIRE dans la base de données (par opposition à la
 * classe UserRepository qui est responsable de LIRE).
 *
 * Note: les méthodes de cet classe ne renvoient aucune valeur
 * car en cas d'erreur elles "lèveraient une exception".
 * @see https://www.php.net/manual/fr/language.exceptions.php
 * @see https://www.php.net/manual/fr/pdo.connections.php
 */
class CategorieRessourceManager
{
    /** PDO */
    private $connection;

    /** @var EncoderInterface */
    private $encoder;

    /**
     * Constructor.
     *
     * @param PDO              $connection La connection à la base de données
     * @param EncoderInterface $encoder    Encodeur de mot de passe
     */
    public function __construct(PDO $connection, EncoderInterface $encoder)
    {
        $this->connection = $connection;
        $this->encoder = $encoder;
    }
}
