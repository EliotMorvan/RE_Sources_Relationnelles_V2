<?php

namespace Security;

use Entity\User;
use Repository\UserRepository;

/**
 * Class Security
 *
 * Objet responsable de la sécurité.
 */
class Security
{
    // L'index avec lequel l'identifiant de l'utilisateur
    // sera stocké dans la session
    public const KEY = 'user_id';

    /**
     * Le dépôt des utilisateurs
     * @var UserRepository
     */
    private $repository;

    /**
     * L'encodeur de mot de passe
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * Drapeau (flag) permettant de savoir
     * si l'authentification a déjà été effectuée.
     * (Faux par défaut, voir la méthode authenticate())
     * @var bool
     */
    private $initialized = false;

    /**
     * L'utilisateur connecté
     * (peut être vide)
     * @var User
     */
    private $user;

    /**
     * L'erreur d'authentification
     * (peut être vide)
     * @var string
     */
    private $error;


    public function __construct(UserRepository $repository, EncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * Renvoi l'utilisateur connecté, ou la valeur nulle.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        // Authentifie l'utilisateur
        $this->authenticate();

        return $this->user;
    }

    public function isTaken(string $pseudo, array $pseudos): bool
    {
        return true;
    }

    /**
     * Renvoi l'utilisateur connecté, ou la valeur nulle.
     *
     * @return bool|null
     */
    public function isConnected(): bool
    {
        // Authentifie l'utilisateur
        $this->authenticate();

        return $this->user->getDroit() >= 0;
    }

    /**
     * Renvoi l'utilisateur connecté, ou la valeur nulle.
     *
     * @return bool|null
     */
    public function isModerateur(): bool
    {
        // Authentifie l'utilisateur
        $this->authenticate();

        return $this->user->getDroit() >= 1;
    }

    /**
     * Renvoi l'utilisateur connecté, ou la valeur nulle.
     *
     * @return bool|null
     */
    public function isAdministrateur(): bool
    {
        // Authentifie l'utilisateur
        $this->authenticate();

        return $this->user->getDroit() >= 2;
    }

    /**
     * Renvoi l'utilisateur connecté, ou la valeur nulle.
     *
     * @return bool|null
     */
    public function isSuperAdministrateur(): bool
    {
        // Authentifie l'utilisateur
        $this->authenticate();

        return $this->user->getDroit() >= 3;
    }

    /**
     * Renvoi l'erreur d'authentification, ou la valeur nulle.
     *
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Authentifie l'utilisateur.
     *
     * @param string $email    L'adresse email saisie par l'internaute (formulaire).
     * @param string $password Le mot de passe saisi par l'internaute (formulaire).
     *
     * @return bool Si l'authentification a réussi ou non.
     */
    public function login(string $email, string $password): bool
    {
        // Supprimer un éventuel précédent message d'erreur.
        $this->error = '';

        // Utilise le service "dépôt" (repository) pour
        // récupérer l'utilisateur par son adresse email
        $user = $this->repository->findOneByEmail($email);

        // Si aucun utilisateur trouvé
        if (null === $user) {
            // Défini le message d'erreur
            $this->error = 'Utilisateur introuvable.';

            return false; // Échec de l'authentification
        }

        // Utilisateur le service "encodeur" pour encoder
        // le mot de passe saisi par l'internaute
        $password = $this->encoder->encode($password);

        // Si le mot de passe saisir par l'internaute est différent
        // du mot de passe stocké dans la base de données.
        if ($password !== $user->getPassword()) {
            // Défini le message d'erreur
            $this->error = 'Le mot de passe ne correspond pas.';

            return false; // Échec de l'authentification
        }

        // Stocke l'identifiant de l'utilisateur dans la session
        // (la session permet de conserver des données entre les
        // différentes pages du site lorsque l'internaute navigue)
        $_SESSION[self::KEY] = $user->getId();

        // Authentification réussie
        return true;
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(): void
    {
        // On détruit l'index 'user_id' du tableau associatif 'session'.
        unset($_SESSION[self::KEY]);
    }

    /**
     * Authentifie l'utilisateur :
     * Vérifie qu'un utilisateur stocké dans la base de données
     * correspond à l'identifiant stocké dans la session.
     */
    private function authenticate(): void
    {
        // Si l'authentification a déjà été effectué
        if ($this->initialized) {
            // On s'arrête ici pour ne pas exécuter la suite
            // du code de cette méthode inutilement (le résultat
            // serait le même)
            return;
        }

        // Marque l'authentification comme ayant été traitée.
        $this->initialized = true;

        // Si la session ne contient PAS l'identifiant de l'utilisateur
        if (!isset($_SESSION[self::KEY])) {
            // On s'arrête ici
            return;
        }

        // Récupère l'identifiant de l'utilisateur stocké dans la session
        // et le converti en nombre entier (intval).
        $id = intval($_SESSION[self::KEY]);

        // Récupère l'utilisateur
        $this->user = $this->repository->findOneById($id);
    }
}
