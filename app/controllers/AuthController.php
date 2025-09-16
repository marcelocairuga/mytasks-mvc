<?php
namespace MyTasks\Controllers;

use MyTasks\Services\UserService;
use MyTasks\Core\ViewHelper;
use MyTasks\Core\AuthHelper;
use MyTasks\Core\Request;
use InvalidArgumentException;
use DomainException;

class AuthController {
    private UserService $userService;
    private Request $request;

    public function __construct(ViewHelper $viewHelper, AuthHelper $authHelper, Request $request, UserService $userService) {
        $this->viewHelper = $viewHelper;
        $this->authHelper = $authHelper;
        $this->request = $request;
        $this->userService = $userService;
    }

    public function showLoginForm(): void {
        // se já está autenticado, redireciona para o dashboard
        if ($this->authHelper->isAuthenticated()) {
            $this->viewHelper->redirect('/');
            return;
        }
        // caspo contrário, mostra o formulário de login
        $this->viewHelper->render('auth/login');
    }

    // POST /auth/login
    public function handleLogin(): void {
        try {
            // busca dados do formulário
            $email = $this->request->post['email'] ?? '';
            $password = $this->request->post['password'] ?? '';
            $user = $this->userService->authenticate($email, $password);

            // Login bem-sucedido, inicia sessão
            $this->authHelper->login($user->getId(), $user->isAdmin());
            $this->viewHelper->redirect('/');
        } catch (DomainException $e) {
            $this->viewHelper->render('auth/login', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    // GET /auth/logout
    public function handleLogout(): void {
        $this->authHelper->logout();
        $this->viewHelper->redirect('/auth/login');
    }
}