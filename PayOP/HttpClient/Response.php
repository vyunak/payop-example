<?php

namespace PayOp\HttpClient;

use http\Exception\RuntimeException;

class Response
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $body;

    public function __construct($code, $response)
    {
        $this->code = $code;
        $this->body = json_decode($response->getBody(), true);
        $this->handleError($response);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param Response $response
     * @return void
     */
    public function handleError(Response $response)
    {
        $code = $response->getCode();

        switch ($code) {
            case 200:
                return;
            case 422:
                throw new RuntimeException('Unprocessable Entity.');
            case 500:
                throw new RuntimeException('Internal server error.');
            default:
                throw new RuntimeException('Unexpected status.');
        }
    }
}