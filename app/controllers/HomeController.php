<?php
namespace MyTasks\Controllers;

use MyTasks\Core\ViewHelper;
use MyTasks\Core\AuthHelper;

class HomeController {
    private ViewHelper $viewHelper;
    private AuthHelper $authHelper;

    public function __construct(ViewHelper $viewHelper, AuthHelper $authHelper) {
        $this->viewHelper = $viewHelper;
        $this->authHelper = $authHelper;
    }

    // GET /
    public function showDashboard(): void {
        if (!$this->authHelper->isAuthenticated()) {
            $this->viewHelper->redirect('/auth/login');
            return;
        }

        $this->viewHelper->render('home/dashboard', [
            'userId' => $this->authHelper->getUserId(),
            'isAdmin' => $this->authHelper->isAdmin()
        ]);
    }
}