<?php

namespace Security;

/**
 * Interface EncoderInterface
 *
 * Responsable de l'encodage de mot de passe.
 * Tous les 'encoders' devront IMPLÉMENTER cette interface,
 * et devront donc définir la méthode 'encode'.
 */
interface EncoderInterface
{
    /**
     * Encode la chaîne de caractères passée en paramètre.
     *
     * @param string $plain La chaîne de caractère 'en clair'.
     *
     * @return string La chaîne de caractère encodée.
     */
    public function encode(string $plain): string;
}
