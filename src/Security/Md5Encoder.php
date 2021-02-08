<?php

namespace Security;

/**
 * Class Md5Encoder
 *
 * Encodeur de mot de passe utilisant l'algorithme de hashage MD5.
 */
class Md5Encoder implements EncoderInterface
{
    /**
     * @inheritDoc
     * (voir EncoderInterface)
     */
    public function encode(string $plain): string
    {
        return md5($plain);
    }
}
