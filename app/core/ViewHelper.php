<?php
namespace MyTasks\Core;

class ViewHelper
{
    public string $projectRoot;
    public string $basePath;

    public function __construct(string $basePath, string $projectRoot)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->projectRoot = rtrim($projectRoot, '/');
    }

    private function viewPath(string $view): string
    {
        return $this->projectRoot . '/app/views/' . ltrim($view, '/') . '.php';
    }

    public function asset(string $asset): string
    {
        return $this->basePath . '/public/' . ltrim($asset, '/');
    }

    public function redirect(string $path): void {
        header('Location: ' . $this->basePath . '/' . ltrim($path, '/'));
        exit;
    }

    public function url(string $path): string {
        return $this->basePath . '/' . ltrim($path, '/');
    }

    public function render(string $view, array $vars = []): void {
        extract($vars); // cria variáveis a partir do array
        require_once $this->viewPath($view);
    }
}