<?php
namespace MyTasks\Core;

class AuthHelper
{
    private array $storage;

    public function __construct(array &$storage)
    {
        $this->storage = &$storage; // pode ser $_SESSION ou outro array
    }

    public function isAuthenticated(): bool
    {
        return isset($this->storage['user_id']);
    }

    public function getUserId(): string|null
    {
        return $this->storage['user_id'] ?? null;
    }

    public function isAdmin(): bool
    {
        return $this->storage['is_admin'] ?? false;
    }

    public function login(string $userId, bool $isAdmin): void
    {
        $this->storage['user_id'] = $userId;
        $this->storage['is_admin'] = $isAdmin;
    }

    public function logout(): void
    {
        $this->storage = [];
        session_destroy();
    }
}