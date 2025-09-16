<?php
namespace MyTasks\Core;

class Request
{
    public readonly array $get;
    public readonly array $post;
    public readonly array $server;
    public readonly string $basePath;

    public function __construct(array $get, array $post, array $server, string $basePath)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->basePath = $basePath;
    }

    // Método HTTP da requisição
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';        
    }

    // URL path da requisição
    public function getPath(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);
        $path = substr($path, strlen($this->basePath));
        return $path ?: '/';
    }
}
