<?php

namespace Sruuua\HTTPBasics;

class Request
{
    private array $header;

    private array $serverInfos;

    private array $get;

    private array $body;

    private string $requestedPage;

    private string $method;

    public static function getRequest()
    {
        return new static;
    }

    public function __construct()
    {
        $this->header = getallheaders();
        $this->serverInfos = $_SERVER;
        $this->get = $_GET;
        $this->body = $_POST;
        $this->requestedPage = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getAuthorization(): ?string
    {
        return $this->header['Authorization'] ?? null;
    }

    public function checkAuthorization()
    {
        if (str_starts_with($this->getAuthorization(), 'Basic')) {
            return ['Method' => 'Basic', 'username' => $this->serverInfos['PHP_AUTH_USER'], 'password' => $this->serverInfos['PHP_AUTH_PW']];
        }
    }

    public function getRequestedPage(): string
    {
        return $this->requestedPage;
    }

    public function get(): array
    {
        return $this->get;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getMethod()
    {
        return $this->method;
    }
}