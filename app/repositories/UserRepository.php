<?php
namespace MyTasks\Repositories;

use PDO;
use MyTasks\Entities\User;

class UserRepository {
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function findById(int $id): User|null {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return $this->hydrateUser($row);
    }

    public function findAll(): array {
        $stmt = $this->connection->query("SELECT * FROM users");
        $rows = $stmt->fetchAll();

        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->hydrateUser($row);
        }
        return $users;
    }

    public function create(User $user): int {
        $stmt = $this->connection->prepare("
            INSERT INTO users (name, email, password, is_admin)
            VALUES (:name, :email, :password, :is_admin)
        ");
        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'is_admin' => $user->isAdmin() ? 1 : 0
        ]);
        return (int) $this->connection->lastInsertId();
    }

    public function update(User $user): bool {
        $stmt = $this->connection->prepare("
            UPDATE users
            SET name = :name, email = :email, password = :password, is_admin = :is_admin
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'is_admin' => $user->isAdmin() ? 1 : 0
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function findByEmail(string $email): User|null {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return $this->hydrateUser($row);
    }

    private function hydrateUser(array $row): User {
        return new User(
            (int) $row['id'],
            $row['name'],
            $row['email'],
            $row['password'],
            (bool) $row['is_admin']
        );
    }
}