<?php

namespace Http;

use InvalidArgumentException;

class JsonResponse extends Response
{
    public function __construct($content, int $code = 200, array $headers = [])
    {
        if (is_array($content)) {
            $content = json_encode($content);
        } elseif (!is_string($content)) {
            throw new InvalidArgumentException("Expected array or string.");
        }

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        parent::__construct($content, $code, $headers);
    }
}
