<?php
require_once __DIR__ . '/../app/config/bootstrap.php';

use MyTasks\Core\Router;
use MyTasks\Core\Request;

$request = $container->get(Request::class);
$path = $request->getPath();
$method = $request->getMethod();

$router = $container->get(Router::class);
$router->dispatch($path, $method);