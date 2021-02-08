<?php

namespace Http;

/**
 * Class Response
 *
 * Utilitaire pour des opérations HTTP récurrentes.
 */
class Response
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $code;

    /**
     * @var array
     */
    private $headers;


    /**
     * Constructor.
     *
     * @param string $content
     * @param int    $code
     * @param array  $headers
     */
    public function __construct(string $content, int $code = 200, array $headers = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * Returns the content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Returns the code.
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Returns the headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Sends the response.
     */
    public function send(): void
    {
        http_response_code($this->code);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->content;
    }
}
