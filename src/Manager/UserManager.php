<?php

namespace Manager;

use Entity\User;
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
class UserManager
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

    /**
     * Ajoute un utilisateur dans la base données.
     *
     * @param User $user L'instance de la classe User
     *                   à enregistrer dans la base de données.
     */
    public function insert(User $user): void
    {
        // Prépare une requête d'insertion d'un utilisateur
        $insert = $this->connection->prepare(
            'INSERT INTO user(email, password, droit, nom, prenom) '.
            'VALUES (:email, :password, :droit, :nom, :prenom);'
        );

        // Encode le mot de passe de l'utilisateur
        $encoded = $this->encoder->encode($user->getPlainPassword());
        $user->setPassword($encoded);

        // Execute la requête d'insertion
        $insert->execute([
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'droit'    => 0,
            'nom'      => $user->getNom(),
            'prenom'      => $user->getPrenom(),
        ]);

        // Mettre à jour l'identifiant de l'utilisateur
        $user->setId($this->connection->lastInsertId());
    }

    /**
     * Mets à jour un utilisateur dans la base de données.
     *
     * @param User $user L'instance de la classe User
     *                   à modifier dans la base de données.
     */
    public function update(User $user): void
    {
        // Si l'identifiant de l'utilisateur n'est pas un nombre entier positif
        if (0 >= $user->getId()) {
            // On ne peut pas mettre à jour cet utilisateur
            throw new \Exception("User must have an id");
        }

        // Les champs que l'on souhaite mettre à jour
        // (à gauche, le nom de la colonne de la base de données)
        $couples = [
            'email=' . $this->connection->quote($user->getEmail()),
        ];

        // Si le mot de passe à été modifié par l'internaute
        if (!empty($user->getPlainPassword())) {
            // Encode le mot de passe de l'utilisateur
            $encoded = $this->encoder->encode($user->getPlainPassword());
            $user->setPassword($encoded);

            // Ajoute à la liste des champs à mettre à jour
            $couples[] = 'password=' . $this->connection->quote($encoded);
        }
        //Ajout champ droit
        $couples[] = 'droit=' . $this->connection->quote($user->getDroit());

        // Ajout du Nom / Prenom
        $couples[] = 'nom' . $this->connection->quote($user->getNom());
        $couples[] = 'prenom' . $this->connection->quote($user->getPrenom());
        
        // Execute la requête de mise à jour
        $this->connection->query(
            'UPDATE user SET ' . implode(',', $couples) .
            ' WHERE id=' . $user->getId() . ' LIMIT 1'
        );
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @param User $user L'instance de la classe User
     *                   à supprimer de la base de données.
     */
    public function remove(User $user): void
    {
        // Si l'identifiant de l'utilisateur n'est pas un nombre entier positif
        if (0 >= $user->getId()) {
            // On ne peut pas supprimer cet utilisateur
            throw new \Exception("User must have an id");
        }

        // Prépare la requête de suppression
        $delete = $this->connection->prepare(
            'DELETE FROM user WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de suppression
        $delete->execute([
            'param_id' => $user->getId(),
        ]);
    }
}
