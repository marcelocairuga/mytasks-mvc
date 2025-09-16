<?php
namespace MyTasks\Entities;

class User {
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $is_admin;

    public function __construct($id = null, $name = '', $email = '', $password = '', $is_admin = false) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }

    public function getId(): int | null {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function isAdmin(): bool {
        return $this->is_admin;
    }
}