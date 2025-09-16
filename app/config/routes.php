<?php
use MyTasks\Controllers\AuthController;
use MyTasks\Controllers\HomeController;

$router->get('/auth/login', [AuthController::class, "showLoginForm"]);
$router->post('/auth/login', [AuthController::class, "handleLogin"]);
$router->get('/auth/logout', [AuthController::class, "handleLogout"]);
$router->get('/', [HomeController::class, "showDashboard"]);