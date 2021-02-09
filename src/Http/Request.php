<?php

namespace Http;

class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    public static function createFromGlobals(): Request
    {
        $method = $_SERVER['REQUEST_METHOD']; //'GET'
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // '/admin'

        return new self($method, $path);
    }

    private function __construct(string $method, string $path)
    {
        $this->method = $method;
        $this->path = $path;
    }

    /**
     * Returns the method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
