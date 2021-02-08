<?php

namespace Http;

class RedirectResponse extends Response
{
    public function __construct(string $path, int $code = 302)
    {
        parent::__construct('', $code, [
            'Location' => $path
        ]);
    }
}
