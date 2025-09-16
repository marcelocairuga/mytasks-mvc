<?php
require_once __DIR__ . '/autoload.php';

use MyTasks\Database\Database;
use MyTasks\Core\Container;
use MyTasks\Repositories\UserRepository;
use MyTasks\Services\UserService;   
use MyTasks\Controllers\AuthController;
use MyTasks\Controllers\HomeController;
use MyTasks\Core\Router;
use MyTasks\Core\Request;
use MyTasks\Core\ViewHelper;
use MyTasks\Core\AuthHelper;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$basePath = preg_replace('#/public$#', '', dirname($_SERVER['SCRIPT_NAME']));
$projectRoot = dirname(__DIR__, 2);

$container = new Container();

$container->set(ViewHelper::class, function() use ($basePath, $projectRoot) {
    return new ViewHelper($basePath, $projectRoot);
});

$container->set(AuthHelper::class, function() {
    return new AuthHelper($_SESSION);
});

$container->set(Request::class, function() use ($basePath) {
    return new Request($_GET, $_POST, $_SERVER, $basePath);
});

$container->set(Router::class, function($c) use ($basePath) {
    $router = new Router($c, $basePath);
    require_once __DIR__ . '/routes.php';
    return $router;
});

$container->set(PDO::class, function() {
    $db_config = require_once __DIR__ . '/db_config.php';
    $database = new Database($db_config);
    $pdo = $database->getConnection();
    return $pdo;
});

$container->set(UserRepository::class, function($c) {
    return new UserRepository($c->get(PDO::class));
});

$container->set(UserService::class, function($c) {
    return new UserService($c->get(UserRepository::class));
});

$container->set(AuthController::class, function($c) {
    $viewHelper = $c->get(ViewHelper::class);
    $authHelper = $c->get(AuthHelper::class);
    $request = $c->get(Request::class);
    $userService = $c->get(UserService::class);
    return new AuthController($viewHelper, $authHelper, $request, $userService);
});

$container->set(HomeController::class, function($c) {
    $viewHelper = $c->get(ViewHelper::class);
    $authHelper = $c->get(AuthHelper::class);
    return new HomeController($viewHelper, $authHelper);
});