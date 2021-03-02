<?php

namespace Validator;

use Entity\User;

/**
 * Class UserValidator
 *
 * Service (objet) responsable de la validation d'un utilisateur.
 */
class UserValidator
{
    /**
     * Valide l'utilisateur passé en paramètre.
     *
     * @param User $user L'instance de la classe User à valider.
     *
     * @return array Tableau associatif contenant les erreurs de validation.
     *               [<champ> => <erreur>]
     */
    public function validate(User $user): array
    {
        $errors = [];

        if (empty($user->getEmail())) {
            $errors['email'] = "Veuillez saisir une adresse email.";
        } elseif (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Cette adresse email n'est pas valide.";
        }

        if (empty($user->getPrenom())) {
            $errors['prenom'] = "Veuillez saisir votre prénom.";
        }

        if (empty($user->getNom())) {
            $errors['nom'] = "Veuillez saisir votre nom.";
        }

        // Si l'utilisateur n'a pas d'identifiant
        // (on s'apprête à créer cet utilisateur)
        if (null === $user->getId()) {
            // L'internaute doit saisir un mot de passe (en clair / non encodé)
            if (empty($user->getPlainPassword())) {
                $errors['password'] = "Veuillez saisir un mot de passe.";
            }
        }

        return $errors;
    }
}
