<?php
namespace MyTasks\Core;

use MyTasks\Core\Container;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    // Registra uma rota GET
    public function get(string $path, array $handler) : void
    {
        $this->routes['GET'][$path] = $handler;
    }

    // Registra uma rota POST
    public function post(string $path, array $handler) : void
    {
        $this->routes['POST'][$path] = $handler;
    }

    // Instancia o controller e chama o método correspondente
    public function dispatch(string $path, string $method) : void
    {                
        if (isset($this->routes[$method][$path])) {
            [$class, $handler] = $this->routes[$method][$path];
            $controller = $this->container->get($class);
            call_user_func([$controller, $handler]);
        } else {
            http_response_code(404);
            echo "<h1>Ops! Página não encontrada...</h1>";
        }
    }
}